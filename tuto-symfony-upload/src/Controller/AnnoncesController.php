<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Images;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonces")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="annonces_index", methods={"GET"})
     */
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        return $this->render('annonces/index.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="annonces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //////////////////////////// Code à rejouter pour upload une image ////////////////////////////

            // On récupère les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images 
            foreach($images as $images) {
                //On génère un nouveau nom de fichier
                $fichier = md5(uniqid())  . '.' . $images->guessExtension();

                // On copie le fichier dans le dossier uploads 
                $images->move(
                    $this->getParameter('images_directory'),
                    // Ne pas oublier d'ajouter le paramètres images_directory: '%kernel.project_dir%/public/uploads' dans services.yaml
                    $fichier
                );

                // On stcok l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $annonce->addImage($img);
            }

            /////// Fin du code à ajouter pour l'uploads d'images/ Voir plus bas dans la page pour la suppression / Ne pas oublier d'ajouter cascade={"persist"} dans l'Entity du même nom au niveau de la route pour l'image, pour exemple voir sur ce tuto le fichier Annonces.php /////////////////////

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('annonces/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_show", methods={"GET"})
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonces_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonces $annonce): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /////////////////////////////////////// Code à rajouter pour maj l'image /////////////////////////////////////////

            // On récupère les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images 
            foreach($images as $images) {
                //On génère un nouveau nom de fichier
                $fichier = md5(uniqid())  . '.' . $images->guessExtension();

                // On copie le fichier dans le dossier uploads 
                $images->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stock l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $annonce->addImage($img);
            }

            /////////////////////////////////////// Fin du Code à rajouter pour maj l'image /////////////////////////////////////////

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonces_index');
        }

        return $this->render('annonces/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonces_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Annonces $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonces_index');
    }

    ///////////////////////////////////////////// Code à rajouter pour supprimer l'image /////////////////////////////////////////

    /**
     * @Route("/supprime/image/{id}", name="annonces_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    ///////////////////////////////////////////// Fin du Code à rajouter pour supprimer l'image /////////////////////////////////////////
}
