<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SettingRepository;

/**
 * @Route("/user/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_index", methods={"GET"})
     */
    public function index(CartRepository $cartRepository, SettingRepository $settingRepository): Response
    {
        $user = $this->getUser();
        $settings = $settingRepository->findAll();
        $carts = $cartRepository->findCart();
        $totalPrice = $cartRepository->findTotalAmount($user->getId());
        /*dump($carts);
        die();*/

        return $this->render('cart/index.html.twig', [
            'setting' => $settings[0],
            'carts' => $carts,
            'total' => $totalPrice,
        ]);
    }

    /**
     * @Route("/new/{car_id}", name="cart_new", methods={"GET","POST"})
     */
    public function new(Request $request, $car_id): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $cart->setUserid($user->getId());
            $cart->setCarid($car_id);
            $cart->setStatus(1);
            $cart->setCreatedAt(new \DateTime);
            $cart->setUpdatedAt(new \DateTime);
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('cart_index');



            /*$data = $form->getData();
            $pickupDate = $data->getPickupdate()->format('m/d/Y');
            $returnDate = $data->getReturndate()->format('m/d/Y');

            $datetime1 = date_create($pickupDate);
            $datetime2 = date_create($returnDate);

            $interval = date_diff($datetime1, $datetime2);

            $diff = $interval->format('%a');*/




            /*echo $diff. '<br>';
            dump($data);
            die();*/
        }

        return $this->render('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cart_show", methods={"GET"})
     */
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cart_index');
        }

        return $this->render('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cart $cart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cart_index');
    }
}
