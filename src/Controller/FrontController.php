<?php

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends CustomAbstractController
{
    /**
     * @Route("/", name="main")
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->redirectToRoute('tournament');
    }

}
