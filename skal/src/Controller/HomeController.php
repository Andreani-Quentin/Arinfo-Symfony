<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\BarRepository;
use App\Repository\CityRepository;
use App\Repository\ImagesRepository;
use App\Repository\ReviewRepository;
use App\Entity\Bar;
use App\Entity\User;
use App\Entity\City;
use App\Entity\Images;
use App\Entity\Review;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BarRepository $bar, CityRepository $city, ImagesRepository $images, ReviewRepository $review): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',

            'bar' => $bar->findAll(),
            'city' => $city->findAll(),
            'images' => $images->findAll(),
            'review' => $review->findAll(),
        ]);
    }
}
