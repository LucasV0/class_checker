<?php

namespace App\Controller;

use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session/delete/{id}', name: 'app_session' , methods: ['DELETE'])]
    public function delete(Session $session, EntityManagerInterface $manager, Request $request): JsonResponse
    {
        $json = [];
        $date = $session->getDate()->format('d/m/Y');
        if ($request->isXmlHttpRequest()) {
            $manager->remove($session);
            $manager->flush();

            $json= ['response' =>'ok',
            'date' => $date,
            ];
        }else {
            $json= ['response' => 'ko'];
        }
        return new JsonResponse($json);
    }
}
