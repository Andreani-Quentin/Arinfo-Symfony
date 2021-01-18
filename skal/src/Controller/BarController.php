<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReviewRepository;
use App\Repository\BarRepository;
use App\Form\ReviewType;
use App\Entity\Review;
use App\Entity\Images;
use App\Form\BarType;
use App\Entity\City;
use App\Entity\User;
use App\Entity\Bar;




/**
 * @Route("/bar")
 */
class BarController extends AbstractController
{
    ////////////////////// Code à rejouter pour dater l'article //////
    public function createAction(Request $request)
    {
        // en créant un object Article, le constructeur de l'entité Article initialise la date à la date du jour.
        // Le formulaire symfony se chargera d'hydrater ton input date avec la valeur du champ date de l'entité article
        $form = $this->createFormBuilder(new Bar()); //nul besoin de set la date grâce au constructeur
    }
    /////// Ne pas oublier l'autre bout de code dans l'Entity du même nom///////

    /**
     * @Route("/", name="bar_index", methods={"GET"})
     */
    public function index(BarRepository $barRepository): Response
    {
        return $this->render('bar/index.html.twig', [
            'bars' => $barRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bar = new Bar();
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        //////////////////// Code à rajouter pour stocker automatiquer user ///

        $user = $this->getUser();
        $bar = new Bar();
        $bar->setUser($user);
        $form = $this->createForm('App\Form\BarType', $bar);
        $form->handleRequest($request);

        //////////////////////////////////////////////////////////////////////

        if ($form->isSubmitted() && $form->isValid()) {

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

                // On stock l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $bar->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bar);
            $entityManager->flush();

            return $this->redirectToRoute('bar_index');
        }

        return $this->render('bar/new.html.twig', [
            'bar' => $bar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bar_show",  methods={"GET","POST"}, requirements={"bar"="\d+"})
     * @param bar $bar
     * @return Response
     */
    public function show(Request $request, Bar $bar, EntityManagerInterface $manager)
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setCreatedAt(new \DateTime())
            ->setBar($bar)
            ->setUser($this->getUser());

            $manager->persist($review);
            $manager->flush();
        }
        return $this->render('bar/show.html.twig', [
            'bar' => $bar,
            'reviewsForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bar $bar): Response
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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
                $bar->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bar_index');
        }

        return $this->render('bar/edit.html.twig', [
            'bar' => $bar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bar $bar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bar_index');
    }

    /**
     * @Route("/supprime/image/{id}", name="bar_delete_image", methods={"DELETE"})
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
}
