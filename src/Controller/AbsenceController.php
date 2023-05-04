<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/absence')]
class AbsenceController extends AbstractController
{
    #[Route('/', name: 'app_absence_index', methods: ['GET'])]
    public function index(AbsenceRepository $absenceRepository): Response
    {
        $currentUser = $this->getUser();
        return $this->render('absence/index.html.twig', [
            'absences' => $absenceRepository->findAll(),
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/new', name: 'app_absence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AbsenceRepository $absenceRepository): Response
    {
        $currentUser = $this->getUser();
        $absence = new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $absenceRepository->save($absence, true);

            return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('absence/new.html.twig', [
            'absence' => $absence,
            'form' => $form,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_show', methods: ['GET'])]
    public function show(Absence $absence): Response
    {
        $currentUser = $this->getUser();
        return $this->render('absence/show.html.twig', [
            'absence' => $absence,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Absence $absence, AbsenceRepository $absenceRepository): Response
    {
        $currentUser = $this->getUser();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $absenceRepository->save($absence, true);

            return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('absence/edit.html.twig', [
            'absence' => $absence,
            'form' => $form,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_delete', methods: ['POST'])]
    public function delete(Request $request, Absence $absence, AbsenceRepository $absenceRepository): Response
    {
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            $absenceRepository->remove($absence, true);
        }
        $this->addFlash('success', 'L\'absence a bien été supprimée');
        return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
    }
}
