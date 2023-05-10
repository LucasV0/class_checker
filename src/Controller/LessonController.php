<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Period;
use App\Entity\Session;
use App\Form\LessonType;
use App\Repository\AbsenceRepository;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

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
    public function index(LessonRepository $repository, Request $request, PeriodRepository $periodRepository, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Cours', $this->generateUrl('app_lesson'));

        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $currentUser = $this->getUser();
        $val = $periodRepository->findOneBy((['currentPeriod' => true]));
        $lesson =$repository -> findBySession($val->getSession());



        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * @param Request $request
     * @param AbsenceRepository $absRepository
     * @param Lesson $lesson
     * @return JsonResponse|Response
     */
    #[Route('/lesson/get/{id}', name: 'app_lesson_get', methods: ['GET'])]
    public function getLesson(Request $request, AbsenceRepository $absRepository, Lesson $lesson): JsonResponse|Response
    {
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
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
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $currentUser = $this->getUser();
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $lesson->setTeacher($currentUser);
            $manager->persist($lesson);
            $dateEnd = $lesson->getTimeEnd();
            $dateStart = $lesson->getTimeStart();
            $day = $lesson->getDay();
            $dateNow = $dateStart;
            while ($dateNow <= $dateEnd){
                while (intval($dateNow->format('N')) != $day){
                    $dateNow->modify('+1 day');
                }
                $dateOk = clone $dateNow;
                $session = new Session();
                $session->setDate($dateOk)
                    ->setHourStart($lesson->getHoursStart())
                    ->setHourEnd($lesson->getHoursEnd())
                    ->setLabel($lesson->getLabel())
                    ->setDay($lesson->getDay())
                    ->setLesson($lesson);
                $manager->persist($session);
                $dateNow = clone $dateNow->modify('+1 week');
            }
            $manager->flush();
            return $this->redirectToRoute('app_lesson');
        }

        return $this->render('lesson/New_Lesson.html.twig',
            [
                'form' => $form->createView(),
                'currentUser' => $currentUser,
                
            ]);
    }

    #[Route ('/lesson/{id}/sessions', 'lesson_show_session', methods: ['GET', 'POST'])]
    public function showSession(Lesson $lesson, Request $request, SessionRepository $sessionRepository): Response
    {
        if($this->getUser() === null ){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser() === $lesson->getTeacher() || $this->getUser()->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']){
            $sessions = $sessionRepository->findBy(['lesson' => $lesson], ['date' => 'ASC']);
            return $this->render('session/session.html.twig',
                [
                    'lesson' => $lesson,
                    'sessions' => $sessions,
                ]);
        }else{
            $this->addFlash('error', 'Vous n\'avez pas les droits pour acceder a ce contenu');
            return $this->redirectToRoute('app_lesson');
        }

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
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
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
     */
    #[Route('/lesson/delete/{id}', 'lesson.delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $manager, Lesson $lesson, Request $request): JsonResponse|Response
    {
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $json = [];
        if (!$lesson) {
            $json[] = [
                'type' => 'warning',
                'message' => 'Le cour n\'a pas été trouvé!'
            ];
            return new JsonResponse($json);
        }
        $manager->remove($lesson);
        $manager->flush();
        $json= ['response' =>'ok',
        ];
        return new JsonResponse($json);
    }

    /**
     * @param LessonRepository $lessonRepository
     * @return JsonResponse|Response
     */
    #[Route('/lesson/calendar/get', 'app_lesson_get_calendar', methods: ['GET'])]
    public function onCalendarSetData(LessonRepository $lessonRepository, Request $request): JsonResponse|Response
    {
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
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
