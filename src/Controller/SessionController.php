<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Session;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class SessionController extends AbstractController
{



    #[Route('/session/absence/edit/{id}', name: 'session_students_edit' , methods: ['POST', 'GET'])]
    public function editAbs(Absence $absence, AbsenceRepository $absenceRepository, Request $request, Breadcrumbs $breadcrumbs): Response
    {
        $label = $absence->getSession()->getLabel();
        if (strlen($label) > 20) {
            $label = substr($label, 0 ,20) . '...';
        }
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Cours', $this->generateUrl('app_lesson'));
        $breadcrumbs->addItem($label, $this->generateUrl('lesson_show_session', ['id' => $absence->getSession()->getLesson()->getId()]));
        $breadcrumbs->addItem('Séance du '. $absence->getSession()->getDate()->format('d/m/Y'), $this->generateUrl('lesson_show_session_student', ['id' => $absence->getSession()->getId()]));
        $breadcrumbs->addItem('Modification', $this->generateUrl('session_students_edit', ['id' => $absence->getId()]));
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() === $absence->getSession()->getLesson()->getTeacher() || $this->getUser()->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']){
            $form = $this->createForm(AbsenceType::class, $absence);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $absenceRepository->save($absence, true);

                return $this->redirectToRoute('lesson_show_session_student', ['id' => $absence->getSession()->getId()], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('absence/edit.html.twig', [
                'absence' => $absence,
                'form' => $form,
            ]);
        }

        else{
            $this->addFlash('error', 'Vous n\'avez pas les droits pour acceder a ce contenu');
            return $this->redirectToRoute('lesson_show_session' , ['id' => $absence->getSession()->getLesson()->getId()]);
        }

    }
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
