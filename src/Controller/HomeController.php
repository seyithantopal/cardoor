<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Setting;
use App\Entity\Cart;
use App\Repository\SettingRepository;
use App\Repository\CarRepository;
use App\Repository\ImageRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\FaqRepository;
use App\Form\SettingType;
use App\Entity\Message;
use App\Form\MessageType;
use App\Form\CommentType;
use App\Form\CartType;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository, CarRepository $carRepository, CategoryRepository $categoryRepository)
    {
        $settings = $settingRepository->findAll();
        $cars = $carRepository->findBy(['status' => 1], ['id' => 'DESC'], 5);
        $allCategory = $categoryRepository->findBy(['status' => 1]);
        $category = $carRepository->findByExampleField();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'slogan' => 'BOOK A CAR TODAY',
            'slogan2' => 'FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT FOR OUR RETURNING CUSTOMERS',
            'setting' => $settings[0],
            'cars' => $cars,
            'category' => $category,
            'allCategory' => $allCategory,
        ]);
    }

    /**
     * @Route("/car-detail/{id}", name="details", methods={"GET","POST"})
     */
    public function details(SettingRepository $settingRepository, CarRepository $carRepository, ImageRepository $imageRepository, CategoryRepository $categoryRepository, CommentRepository $commentRepository, $id, Request $request) : Response
    {
        $settings = $settingRepository->findAll();
        $cars = $carRepository->find($id);
        $images = $imageRepository->findBy(['car' => $id]);
        $category = $categoryRepository->find($cars->getCategory());
        $comments = $commentRepository->findByExampleField($id);
        $addedUser = $carRepository->findUser($id);

        $cart = new Cart();
        $cartForm = $this->createForm(CartType::class, $cart);
        $cartForm->handleRequest($request);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setUserid($user->getId());
                $comment->setCarid($id);
                $comment->setIp($_SERVER['REMOTE_ADDR']);
                $comment->setStatus(1);
                $comment->setCreatedAt(new \DateTime);
                $comment->setUpdatedAt(new \DateTime);
                $entityManager->persist($comment);
                $entityManager->flush();
                $this->addFlash('success', 'Your comment has been sent successfully');
            } catch(Exception $e) {
                $this->addFlash('warning', 'An error occurred while your comment had been sent');
            }
            return $this->redirectToRoute('details', ['id' => $id]);
        }

        //dump($cars);
        //die();
        return $this->render('home/car-detail.html.twig', [
            'setting' => $settings[0],
            'car' => $cars,
            'images' => $images,
            'category' => $category,
            'comments' => $comments,
            'form' => $form->createView(),
            'user' => $addedUser[0],
            'cartForm' => $cartForm->createView(),
        ]);
    }

    /**
     * @Route("/about-us/", name="aboutus")
     */
    public function aboutus(SettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        return $this->render('home/about-us.html.twig', [
            'setting' => $settings[0],
        ]);
    }

    /**
     * @Route("/contact/", name="contact", methods={"GET","POST"})
     */
    public function contact(SettingRepository $settingRepository, Request $request) : Response
    {
        $settings = $settingRepository->findAll();
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $message->setCreatedAt(new \DateTime);
                $message->setUpdatedAt(new \DateTime);
                $message->setStatus(1);
                $entityManager->persist($message);
                $entityManager->flush();
                $this->addFlash('success', 'Your message has been sent successfully');

                $email = (new Email())
                    ->from($settings[0]->getSmtpemail())
                    ->to($form['email']->getData())
                    ->subject('Cardoor')
                    ->html('Dear ' . $form['name']->getData() . ',<br><p>We retrieved your request and
                        will answer it as soon as possible.</p><br>' . $settings[0]->getCompany() . '<br>Address: ' . $settings[0]->getAddress() . '<br>Phone: ' . $settings[0]->getPhone());
                $transport = new GmailTransport($settings[0]->getSmtpemail(), $settings[0]->getSmtppassword());
                $mailer = new Mailer($transport);
                $mailer->send($email);
            } catch(Exception $e) {
                $this->addFlash('warning', 'An error occurred while your message had been sent');
            }
            return $this->redirectToRoute('contact');
        }

        /*return $this->render('admin/message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);*/


        return $this->render('home/contact.html.twig', [
            'setting' => $settings[0],
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/faq/", name="faq")
     */
    public function faq(SettingRepository $settingRepository, FaqRepository $faqRepository)
    {
        $settings = $settingRepository->findAll();
        $faq = $faqRepository->findBy(['status' => true]);
        return $this->render('home/faq.html.twig', [
            'setting' => $settings[0],
            'faqs' => $faq,
        ]);
    }
}
