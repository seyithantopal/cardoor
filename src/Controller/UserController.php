<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SettingRepository;
use App\Repository\CategoryRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('user/show.html.twig', [
            'setting' => $settings[0],
            'flag' => 1,
        ]);
    }

    /**
     * @Route("/comments", name="user_comments", methods={"GET"})
     */
    /*public function comments(SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('user/comments.html.twig', [
            'setting' => $settings[0]
        ]);
    }*/

    /**
     * @Route("/{id}/cars", name="user_cars", methods={"GET"})
     */
    public function cars(SettingRepository $settingRepository, CarRepository $carRepository, CategoryRepository $categoryRepository, UserRepository $userRepository, $id): Response
    {
        $settings = $settingRepository->findAll();
        $cars = $carRepository->findBy(['userid' => $id]);

        $allCategory = $categoryRepository->findBy(['status' => 1]);
        $category = $carRepository->findByExampleFieldById($id);
        $user = $userRepository->find($id);
        return $this->render('user/cars.html.twig', [
            'setting' => $settings[0],
            'cars' => $cars,
            'allCategory' => $allCategory,
            'category' => $category,
            'user' => $user,
            'flag' => 0,
        ]);
    }

    /**
     * @Route("/books", name="user_books", methods={"GET"})
     */
    public function books(SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('user/books.html.twig', [
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $file = $form['image']->getData();
            if($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try{
                    $file->move($this->getParameter('image_directory'), $fileName);
                } catch(FileException $e) {

                }
                $user->setImage($fileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user, SettingRepository $settingRepository): Response
    {
        $settings = $settingRepository->findAll();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'setting' => $settings[0],
            'flag' => 0,
        ]);
    }




    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder, SettingRepository $settingRepository, $id): Response
    {
        $user = $this->getUser();
        if($user->getId() != $id) {
            return $this->render('home/404.html.twig', ['msg' => 'WRONG USER', 'sub_msg' => 'THE USER YOU ARE LOOKING FOR IS WRONG', 'flag' => 1]);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $file = $form['image']->getData();
            if($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try{
                    $file->move($this->getParameter('image_directory'), $fileName);
                } catch(FileException $e) {

                }
                $user->setImage($fileName);
                $user->setUpdatedAt(new \DateTime);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        $settings = $settingRepository->findAll();
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'setting' => $settings[0],
            'flag' => 1,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
