<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $currentUser = $this->getUser();

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['currentUser'=> $currentUser,'last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->render('security/login.html.twig');
    }

    // #[Route(path: '/2fa', name: '2fa_login')]
    // public function check2fa(GoogleAuthenticatorInterface $authenticator, TokenStorageInterface $storage)
    // {
    //     $code = $authenticator->getQRContent($storage->getToken()->getUser());
    //     $qrCode = "http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=".$code;
    //     return $this->render('security/2fa_login.html.twig', [
    //         'qrCode' => $qrCode
    //     ]);
    // }
}
