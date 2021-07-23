<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findBy([
            'publier' => true
        ]);
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * @Route("/restaurants/{cat}", name="restaurant_par_cat")
     */
    public function parCat( Categorie $cat ): Response
    {
        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)->findBy([
            'categorie_id' => $cat
        ]);
        return $this->render('restaurant/par_cat.html.twig', [
            'restaurants' => $restaurant,
        ]);
    }

    /**
     * @Route("/new", name="restaurant_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesDirectory = "images/uploads/";
            // donc, on commence par récuperer ce qui a été uploadé
            $imageFile = $form->get('photo')->getData();
            // on test, au cas ou
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on crée un nom unique de stockage du fichier
                $safeFileName = $slugger->slug($originalFilename);
                $finalFilename = $safeFileName . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // on essaye de deplacer le fichier à sa place finale, sur le serveur
                $imageFile->move($imagesDirectory, $finalFilename);
                // et bien sur on n'oubli pas de mettre à jour le path dans l'objet image
                // petite astuce pour ne pas avoir à remettre le dossier dans twig - l'image s'affiche directement
                $completeFileName = "$imagesDirectory$finalFilename";
                $restaurant->setPhoto($completeFileName);
            }
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('restaurant_index', [], Response::HTTP_SEE_OTHER);
    }
}
