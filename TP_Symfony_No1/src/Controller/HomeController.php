<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Proffesseurs;
use App\Repository\ProffesseurRepository;
use App\Repository\ClassesRepository;
use App\Repository\ElevesRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="classes")
     * @isGranted("ROLE_USER")
     */
    public function index(ProffesseurRepository $proffesseur, ClassesRepository $classes, ElevesRepository $eleves): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'classes' => $classes->findAll(),
            'proffesseurs' => $proffesseur->findAll(),
            'eleves' => $eleves->findAll(),
        ]);
    }
}
