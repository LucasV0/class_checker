<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    #[Route('/lesson', name: 'app_lesson')]
    public function index(): Response
    {
        return $this->render('lesson/index.html.twig', [
            'controller_name' => 'LessonController',
        ]);
    }
    /**
     * Controller qui permet de créer un cours dans la bdd
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/new', 'lesson.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $Lesson = new Lesson();
        $form = $this->createForm(Lesson::class, $Lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Lesson = $form->getData();
            $manager->persist($Lesson);
            $manager->flush();
            // do some sort of processing
            $this->addFlash(
                'success',
                'Votre compte à été créé avec succès !'
            );

            return $this->redirectToRoute('app_lesson');
        }

        return $this->render('lesson/New_Lesson.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
}
