<?php

namespace App\Controller;


use App\Entity\Period;
use App\Form\PeriodType;
use App\Repository\PeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeriodController extends AbstractController
{

    #[Route('/period', name: 'app_period' , methods: [ 'GET','POST'])]
    public function index(Request $request, PeriodRepository $repository): Response
    {
        $period = $repository->findAll();

        return $this->render('period/index.html.twig', [
            'periods' => $period,
        ]);
    }

    #[Route('/period/new', name: 'app_period_new' , methods: [ 'GET','POST'])]
    public function new(Request $request, PeriodRepository $repository, EntityManagerInterface $manager): Response
    {
        $period = new Period();
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $period = $form->getData();
            $manager->persist($period);
            $manager->flush();

            return $this->redirectToRoute('app_period');
        }
        return $this->render('period/form.html.twig', [
            'form' => $form,
            'route' => 'app_period_new'
        ]);
    }

    #[Route('/period/{id}', name: 'app_period_edit' , methods: [ 'GET','POST'])]
    public function edit(Request $request, Period $period): Response
    {
        $form = $this->createForm(PeriodType::class, $period);
        return $this->render('period/form.html.twig', [
            'form' => $form,
            'route' => 'app_period_edit'
        ]);
    }
}
