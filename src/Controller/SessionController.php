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
    public function delete(Session $session, EntityManagerInterface $manager, Request $request): JsonResponse|Response
    {
        $json = [];
        $date = $session->getDate()->format('d/m/Y');
        if ($session->getLesson()->getTeacher() === $this->getUser() OR $this->getUser()->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']){
            if ($request->isXmlHttpRequest()) {
                $manager->remove($session);
                $manager->flush();

                $json= ['response' =>'ok',
                    'date' => $date,
                ];
                return new JsonResponse($json);
            }
        }

        return new Response ('error', 404);
    }
}
