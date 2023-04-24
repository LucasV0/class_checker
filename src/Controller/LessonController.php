<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\AbsenceRepository;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Baptiste Caron
 * Controller de l'entity Lesson, qui nous permet de faire tout le CRUD
 */
class LessonController extends AbstractController
{
    /**
     * @method "qui nous permet de trouver toutes les entitées Lesson présentes au sein de la BDD"
     * @param LessonRepository $repository
     * @param Request $request
     * @return Response
     */
    #[Route('/lesson', name: 'app_lesson', methods: ['GET'])]
    public function index(LessonRepository $repository, Request $request, PeriodRepository $periodRepository): Response
    {
        $currentUser = $this->getUser();

        $session = $periodRepository -> findAll();

        $val = "2022/2023";

        $lesson =$repository -> findBySession($val);
        $currentUser = $this->getUser();



        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
            'currentUser' => $currentUser,
            'session' => $session,
        ]);
    }

    #[Route('/lesson/calendar', name: 'app_lesson_calendar', methods: ['GET'])]
    public function calendar(LessonRepository $repository, Request $request): Response
    {
        $currentUser = $this->getUser();
        return $this->render('lesson/calendar.html.twig', [
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/lesson/get/{id}', name: 'app_lesson_get', methods: ['GET'])]
    public function getLesson(Request $request, AbsenceRepository $absRepository, Lesson $lesson): JsonResponse
    {
        $abs = $absRepository->findBy(['lessons' => $lesson]);
        $abss=[];
        $i = 0;
        foreach ($abs as $ab){
            $tab["absent"] = [
                'id' => $ab->getId(),
                'status' => $ab->getJustify()->getStatus(),
                'date' => $ab->getDateJustify()->format('Y-m-d'),
                'lesson' => $ab->getLessons()->getLabel(),
            ];
            $abss[] = $tab;
        }
        $response = new JsonResponse($abss);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;

    }

    /**
     * @method "qui permet" de créer une entité Lesson dans la bdd
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/lesson/nouveau', 'lesson.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $lesson->setTeacher($currentUser);
            $manager->persist($lesson);
            $manager->flush();

            return $this->redirectToRoute('app_lesson');
        }

        return $this->render('lesson/New_Lesson.html.twig',
            [
                'form' => $form->createView(),
                'currentUser' => $currentUser,
                
            ]);
    }

    /**
     * @method" pour modifier" une entités Lesson par rapport a son ID
     * @param Lesson $lesson
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route ('/lesson/modif/{id}', 'lesson.modif', methods: ['GET', 'POST'])]
    public function edit(Lesson $lesson, Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();

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
                'form' => $form->createView(),
                'currentUser' => $currentUser,
            ]);
    }

    /**
     * @method  "de suppression" d'une entitées Lesson par rapport a son id
     * @param EntityManagerInterface $manager
     * @param Lesson $lesson
     * @return Response
     */
    #[Route('/lesson/delete/{id}', 'lesson.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Lesson $lesson): Response
    {
        $currentUser = $this->getUser();

        if (!$lesson) {
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

    /**
     * @param LessonRepository $lessonRepository
     * @return JsonResponse
     */
    #[Route('/lesson/calendar/get', 'app_lesson_get_calendar', methods: ['GET'])]
    public function onCalendarSetData(LessonRepository $lessonRepository): JsonResponse
    {
        $lessons = $lessonRepository->findAll();
        $json= [];
        foreach ($lessons as $lesson){
            $lesson = [
                'allday' => false,
                'id' => $lesson->getId(),
                'title' => $lesson->getLabel(),
                'timeStart' => $lesson->getHoursStart()->format('H:i'),
                'timeEnd' => $lesson->getHoursEnd()->format('H:i'),
                'daysOfWeek' => $lesson->getTimeStart()->format('w'),
                'startRecur' => $lesson->getTimeStart()->format('c'),
                'endRecur' => $lesson->getTimeEnd()->format('Y-m-d'),

            ];
            $json[] = $lesson;
        }
        $response = new JSONResponse($json);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }
}
