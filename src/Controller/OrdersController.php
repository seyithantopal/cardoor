<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrderDetail;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use App\Repository\OrderDetailRepository;
use App\Repository\CartRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(OrdersRepository $ordersRepository, SettingRepository $settingRepository): Response
    {
        $user = $this->getUser();
        $settings = $settingRepository->findAll();

        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findOrdersByUser($user->getId()),
            'setting' => $settings[0],

        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request, SettingRepository $settingRepository, CartRepository $cartRepository): Response
    {
        $user = $this->getUser();
        $settings = $settingRepository->findAll();
        $totalPrice = $cartRepository->findTotalAmount($user->getId());
        $order = new Orders();
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $order->setUserid($user->getId());
            $order->setStatus('New');
            $order->setAmount($totalPrice);
            $order->setCreatedAt(new \DateTime);
            $order->setUpdatedAt(new \DateTime);

            $entityManager->persist($order);
            $entityManager->flush();

            $order_id = $order->getId();

            $entityManager = $this->getDoctrine()->getManager();
            $carts = $cartRepository->findCartsByUser($user->getId());
            /*dump($carts);
            die();*/
            foreach($carts as $cart) {
                $orderDetail = new OrderDetail();
                $orderDetail->setUserid($user->getId());
                $orderDetail->setCarid($cart['carid']);
                $orderDetail->setOrderid($order_id);
                $orderDetail->setPrice($cart['price']);
                $orderDetail->setDays($cart['days']);
                $orderDetail->setamount($cart['total']);
                $orderDetail->setStatus('Ordered');
                $entityManager->persist($orderDetail);
                $entityManager->flush();
            }
            $carts = $cartRepository->deleteCartByUser($user->getId());

            $this->addFlash('success', 'Order completed successfully');


            return $this->redirectToRoute('orders_index');
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'setting' => $settings[0],
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order, SettingRepository $settingRepository, OrderDetailRepository $orderDetailRepository): Response
    {
        $user = $this->getUser();
        $settings = $settingRepository->findAll();
        $orders= $orderDetailRepository->findOrderDetailByUser($user->getId());
        /*dump($orders);
        die();*/
        return $this->render('orders/show.html.twig', [
            'order' => $order,
            'setting' => $settings[0],
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_index');
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }
}
