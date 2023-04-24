<?php

namespace App\Controller;

use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/session', name: 'app_api')]
    public function index(PeriodRepository $periodRepository): JsonResponse
    {
        $sessions = $periodRepository->findAll();
        $json= [];
        foreach ($sessions as $session){
            $json[] = [
                'period' => [
                    'session' => $session->getSession(),
                    'id' => $session->getId()
                ]
            ];
        }

        return new JsonResponse($json);
    }
}
