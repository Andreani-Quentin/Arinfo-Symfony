<?php

namespace App\Controller;

use App\Entity\Joueurs;
use App\Form\JoueursType;
use App\Repository\JoueursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/joueurs")
 */
class JoueursController extends AbstractController
{
    /**
     * @Route("/", name="joueurs_index", methods={"GET"})
     */
    public function index(JoueursRepository $joueursRepository): Response
    {
        return $this->render('joueurs/index.html.twig', [
            'joueurs' => $joueursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="joueurs_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $joueur = new Joueurs();
        $form = $this->createForm(JoueursType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** Code Image **/
            $photoJoueur = $form->get('photoJoueur')->getData();
            if ($photoJoueur) {
                $originalFilename = pathinfo($photoJoueur->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoJoueur->guessExtension();
// Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $photoJoueur->move(
                    $this->getParameter('photos_directory'),
                    $newFilename);
                } catch (FileException $e) {
// ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
// met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
// au lieu de son contenu
                $joueur->setPhotoJoueur($newFilename);
            }
                /** Fin du code à ajouter **/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joueur);
            $entityManager->flush();

            return $this->redirectToRoute('joueurs_index');
        }

        return $this->render('joueurs/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="joueurs_show", methods={"GET"})
     */
    public function show(Joueurs $joueur): Response
    {
        return $this->render('joueurs/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="joueurs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Joueurs $joueur): Response
    {
        $form = $this->createForm(JoueursType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('joueurs_index');
        }

        return $this->render('joueurs/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="joueurs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Joueurs $joueur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($joueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('joueurs_index');
    }
}
