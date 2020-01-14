<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/cars")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", name="user_car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        $user = $this->getUser();
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findBy(['userid' => $user->getId()]),
            'setting' => $settings[0],
            'flag' => 1,
        ]);
    }

    /**
     * @Route("/new", name="user_car_new", methods={"GET","POST"})
     */
    public function new(Request $request, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        $user = $this->getUser();
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $car->setUserid($user->getId());
            $car->setCreatedAt(new \DateTime);
            $car->setUpdatedAt(new \DateTime);
            $file = $form['image']->getData();
            if($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try{
                    $file->move($this->getParameter('image_directory'), $fileName);
                } catch(FileException $e) {

                }
                $car->setImage($fileName);
            }
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('user_car_index');
        }

        return $this->render('car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
            'setting' => $settings[0],
            'flag' => 1,
        ]);
    }

    /**
     * @Route("/{id}", name="user_car_show", methods={"GET"})
     */
    public function show(Car $car, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('car/show.html.twig', [
            'car' => $car,
            'setting' => $settings[0],
            'flag' => 1,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_car_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Car $car, SettingRepository $settingRepository, CarRepository $carRepository, $id): Response
    {
        $settings = $settingRepository->findAll();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        $user = $this->getUser();
        $cars = $carRepository->findBy(['userid' => $user->getId(), 'id' => $id]);
        if(empty($cars)) {
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->redirectToRoute('user_car_index');
            }

            return $this->redirectToRoute('user_car_index');
        }
        else {
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form['image']->getData();
                if($file) {
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                    try{
                        $file->move($this->getParameter('image_directory'), $fileName);
                    } catch(FileException $e) {

                    }
                    $car->setImage($fileName);
                    $car->setUpdatedAt(new \DateTime);
                }
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_car_index');
            }

            return $this->render('car/edit.html.twig', [
                'car' => $car,
                'form' => $form->createView(),
                'setting' => $settings[0],
                'flag' => 1,
            ]);
        }
    }

    /**
     * @Route("/{id}", name="user_car_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Car $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_car_index');
    }

    private function generateUniqueFileName() {
        return md5(uniqid());
    }
}
