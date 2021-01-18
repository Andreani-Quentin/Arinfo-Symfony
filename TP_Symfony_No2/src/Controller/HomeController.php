<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Equipes;
use App\Entity\Club;
use App\Repository\JoueursRepository;
use App\Repository\EquipesRepository;
use App\Repository\ClubRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @isGranted("ROLE_USER")
     */
    public function index(JoueursRepository $joueurs, EquipesRepository $equipes, ClubRepository $club): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            
            'joueurs' => $joueurs->findAll(),
            'club' => $club->findAll(),
        ]);
    }
}