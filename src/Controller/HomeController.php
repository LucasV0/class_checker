<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_home')]
    public function index(MailerService $mailer): Response
    {
        $mailer->sendEmail();
        return $this->render('dashboard.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
}
