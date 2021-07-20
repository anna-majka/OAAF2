<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageListeController extends AbstractController
{
    /**
     * @Route("/page/liste", name="page_liste")
     */
    public function index(): Response
    {
        return $this->render('page_liste/index.html.twig', [
            'controller_name' => 'PageListeController',
        ]);
    }
}
