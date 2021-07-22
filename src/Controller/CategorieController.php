<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Restaurant;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categories")
     */
    public function liste(): Response
    {
        $categorie=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('home/index.html.twig', [
            'categories' => $categorie,
        ]);
    }
}
