<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/*par defaut met admin devant toutes les routes de ce 
controller car elles 
sont protegées par le firewall(pour contrôler les accès)
cf config pakages security.yaml
*/
/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }



    /**
     * @Route("/restaurant/{id}/edit", name="admin_restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurant $restaurant): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restaurant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/form.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/restaurants_a_valider", name="admin_restaurant_a_valid", methods={"GET"})
     */
    public function validation(RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findBy([
            'publier' => null
        ]);
        return $this->render('restaurant/a_valider.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
}

