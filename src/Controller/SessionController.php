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








    /**
     * @param Session $session
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return JsonResponse|Response
     */
    #[Route('/session/delete/{id}', name: 'app_session_delete' , methods: ['DELETE'])]
    public function deleteJson(Session $session, EntityManagerInterface $manager, Request $request): JsonResponse|Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $json = [];
        $date = $session->getDate()->format('d/m/Y');
        if ($session->getLesson()->getTeacher() === $this->getUser() or $this->getUser()->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']) {
            if ($request->isXmlHttpRequest()) {
                $manager->remove($session);
                $manager->flush();

                $json = ['response' => 'ok',
                    'date' => $date,
                ];
                return new JsonResponse($json);
            }
        }

        return new Response ('error', 404);
    }
}
