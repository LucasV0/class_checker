<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BinController extends AbstractController
{
    #[Route('/bin', name: 'app_bin')]
    public function index(): Response
    {
        $currentUser = $this->getUser();
        return $this->render('bin/index.html.twig', [
            'controller_name' => 'BinController',
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('bin/index.html.twig', [
            'controller_name' => 'BinController',
        ]);
    }
}
