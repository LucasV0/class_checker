<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    #[Route('/lesson', name: 'app_lesson', methods: ['GET'])]
    public function index(LessonRepository $repository, Request $request): Response
    {
        $lesson =
            $repository->findAll();



        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }
    /**
     * Controller qui permet de créer un cours dans la bdd
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/lesson/nouveau', 'lesson.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $manager->persist($lesson);
            $manager->flush();

            return $this->redirectToRoute('app_lesson');
        }

        return $this->render('lesson/New_Lesson.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    #[Route ('/lesson/modif/{id}', 'lesson.modif' , methods: ['GET', 'POST'])]
    public function edit(Lesson $lesson, Request $request, EntityManagerInterface $manager) : Response
    {

        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $manager->persist($lesson);
            $manager->flush();

            return $this->redirectToRoute('app_lesson');
        }

        return $this->render('lesson/Modif_Lesson.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    #[Route('/lesson/delete/{id}' , 'lesson.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager , Lesson $lesson) :Response
    {

        if (!$lesson){
            $this->addFlash(
                'warning',
                "Le cour n'a pas été trouvé!"
            );
            return $this->redirectToRoute('app_lesson');
        }

        $manager->remove($lesson);
        $manager->flush();
        $this->addFlash(
            'success',
            'Le cours à été supprimé avec succès !'
        );
        return $this->redirectToRoute('app_lesson');
    }
}
