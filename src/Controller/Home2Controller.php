<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home2Controller extends AbstractController
{
    /**
     * @Route("/", name="home2")
     */
    public function index(): Response
    {
        return $this->render('home2/index.html.twig', [
            'controller_name' => 'Home2Controller',
        ]);
    }
}
