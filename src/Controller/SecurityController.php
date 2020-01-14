<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\SettingRepository;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, SettingRepository $settingRepository): Response
    {
         if ($this->getUser()) {
             $user = $this->getUser();
             if($user->getRoles()[0] == 'ROLE_ADMIN') {
                 return $this->redirectToRoute('admin');
             } else {
                 return $this->redirectToRoute('home');
             }
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $settings = $settingRepository->findAll();

        return $this->render('security/adminlogin.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'setting' => $settings[0]]);
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginadmin(AuthenticationUtils $authenticationUtils): Response
    {
         /*if ($this->getUser()) {
             return $this->redirectToRoute('admin');
         }*/

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();



        return $this->render('security/1adminlogin.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/loginuser", name="login_user")
     */
    public function loginuser(AuthenticationUtils $authenticationUtils, SettingRepository $settingRepository): Response
    {
        /*if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }*/

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $settings = $settingRepository->findAll();

        return $this->render('security/loginuser.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'setting' => $settings[0]]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin()
    {
        return $this->render('admin/admin/index.html.twig');
    }
}
