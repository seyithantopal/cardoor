<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Repository\CarRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="user_image_index", methods={"GET"})
     */
    public function index(ImageRepository $imageRepository, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
            'flag' => 1,
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/new", name="user_image_new", methods={"GET","POST"})
     */
    public function new(Request $request, SettingRepository $settingRepository): Response
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $settings = $settingRepository->findAll();
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file = $form['image']->getData();
            if($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try{
                    $file->move($this->getParameter('image_directory'), $fileName);
                } catch(FileException $e) {

                }
                $image->setImage($fileName);
            }
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('user_car_index');
        }

        return $this->render('image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
            'setting' => $settings[0],
            'user_id' => $user_id,
        ]);
    }

    /**
     * @Route("/{id}", name="user_image_show", methods={"GET"})
     */
    public function show(ImageRepository $imageRepository, CarRepository $carRepository, $id, SettingRepository $settingRepository): Response
    {
        $cars = $carRepository->find($id);
        $settings = $settingRepository->findAll();
        return $this->render('image/index.html.twig', [
            'cars' => $carRepository->find($id),
            'images' => $imageRepository->findBy(['car' => $id]),
            'flag' => 1,
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_image_index');
        }

        return $this->render('image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{c_id}", name="user_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image, $c_id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_image_show', ['id' => $c_id]);
    }

    private function generateUniqueFileName() {
        return md5(uniqid());
    }
}
