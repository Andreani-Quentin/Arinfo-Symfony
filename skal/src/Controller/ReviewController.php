<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReviewRepository;
use App\Repository\BarRepository;
use App\Form\ReviewType;
use App\Form\BarType;
use App\Entity\Review;
use App\Entity\Bar;


/**
 * @Route("/review")
 */
class ReviewController extends AbstractController
{
        public function createAction(Request $request)
    {
        // en créant un object Article, le constructeur de l'entité Article initialise la date à la date du jour.
        // Le formulaire symfony se chargera d'hydrater ton input date avec la valeur du champ date de l'entité article
        $form = $this->createFormBuilder(new Review()); //nul besoin de set la date grâce au constructeur
    }

    /**
     * @Route("/", name="review_index", methods={"GET"})
     */
    public function index(ReviewRepository $reviewRepository, BarRepository $barRepository): Response
    {
        return $this->render('review/index.html.twig', [
            'reviews' => $reviewRepository->findAll(),
            'bar' => $barRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/", name="review_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        $user = $this->getUser();
        $review = new Review();
        $review->setUser($user);
        $form = $this->createForm('App\Form\ReviewType', $review);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('review_index');
        }

        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="review_show", methods={"GET"})
     */
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="review_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Review $review): Response
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_index');
        }

        return $this->render('review/edit.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="review_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('review_index');
    }
}
