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
//        return $this->render('front/index.html.twig', [
        return $this->render('base.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

}
