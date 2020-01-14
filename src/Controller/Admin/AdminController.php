<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrdersRepository;
use App\Repository\OrderDetailRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SettingRepository;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_admin")
     */
    public function index()
    {
        return $this->render('admin/admin/index.html.twig');
    }

    /**
     * @Route("/orders/", name="admin_orders_index")
     */
    public function orders(OrdersRepository $ordersRepository, SettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        $orders = $ordersRepository->findAll();
        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders,
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/orders/{status}", name="admin_orders_index_status")
     */
    public function ordersStatus($status, OrdersRepository $ordersRepository, SettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        $orders = $ordersRepository->findAllOrdersByStatus($status);
        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders,
            'setting' => $settings[0],

        ]);
    }

    /**
     * @Route("/orders/show/{id}", name="admin_orders_show", methods={"GET"})
     */
    public function show(Orders $order, OrderDetailRepository $orderDetailRepository, OrdersRepository $ordersRepository, $id, SettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        $user = $ordersRepository->find($id);
        $orders = $orderDetailRepository->findOrderDetailByUser($user->getUserid());
        /*dump($orders);
        die();*/
        return $this->render('admin/orders/show.html.twig', [
            'order' => $order,
            'orders' => $orders,
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/orders/edit/{id}", name="admin_orders_edit", methods={"GET", "POST"})
     */
    public function edit(Orders $order, OrderDetailRepository $orderDetailRepository, OrdersRepository $ordersRepository, $id, Request $request) : Response
    {
        /*$user = $ordersRepository->find($id);
        $orders = $orderDetailRepository->findOrderDetailByUser($user->getUserid());
        /*dump($orders);*/

        $status = $request->get('status');
        $shipinfo = $request->get('shipinfo');
        $updatedOrders = $ordersRepository->updateOrders($id, $status, $shipinfo);
        $this->addFlash('success', 'Order is updated successfully');
        return $this->redirectToRoute('admin_orders_show', ['id' => $id]);
    }
}
