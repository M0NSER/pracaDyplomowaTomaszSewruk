<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('nieposegregowane/options.html.twig', [
            'controller_name' => 'FrontController',
        ]);

    }

    /**
     * @Route("/options", name="options")
     */
    public function options(): Response
    {
        return $this->render('nieposegregowane/options.html.twig');
    }

    /**
     * @Route("/choosen-option", name="choosen-option")
     */
    public function chooseOption(): Response
    {
        return $this->render('nieposegregowane/choosen_option.html.twig');
    }

    /**
     * @Route("/create-competition", name="create-competition")
     */
    public function createCompetition(): Response
    {
        return $this->render('nieposegregowane/create-competition.html.twig');
    }
}
