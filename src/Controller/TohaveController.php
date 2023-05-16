<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\ToHave;
use App\Form\ToHaveType;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use App\Repository\StudentRepository;
use App\Repository\ToHaveRepository;
use Container4gBMFyD\getToHaveRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use function PHPUnit\Framework\countOf;

class TohaveController extends AbstractController
{
    #[Route('/tohave/{id}', name: 'app_tohave' , methods: ['GET'])]
    public function insert(EntityManagerInterface $manager, Request $request,Lesson $lesson, Breadcrumbs $breadcrumbs, StudentRepository $studentRepository): Response
    {
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Cours', $this->generateUrl('app_lesson'));
        $breadcrumbs->addItem('Ajout d\'élèves', $this->generateUrl('app_tohave', ['id' => $lesson->getId()]));
        if($this->getUser() === null OR $request->getSession()->get('_security_main') === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $students = $studentRepository->findall();
        return $this->render('tohave/index.html.twig', [
            'lesson' => $lesson,
            'students' => $students,
            ]);
    }

    #[Route('/tohave/add', name: 'app_tohave_add' , methods: ['POST'])]
    public function add(EntityManagerInterface $manager, Request $request, StudentRepository $studentRepository): Response
    {
            if ($request->isXmlHttpRequest()){
                $student = $studentRepository->findOneBy(['id' => $request->get('idStudent')]);
                $lesson = $manager->getRepository(Lesson::class)->findOneBy(['id' => $request->get('idLesson')]);
                        $tohave = new ToHave();
                        $tohave->setStudents($studentRepository->findOneBy(['id'=>$student]));
                        $tohave->setLessons($lesson);
                        $manager->persist($tohave);
                    $manager->flush();
                    return new Response('ok', 200);
               }
            else{
                return new Response('ko', 404);
            }

    }
    #[Route('/tohave/del', name: 'app_tohave_del' , methods: ['DELETE'])]
    public function del(EntityManagerInterface $manager, Request $request, ToHaveRepository $toHaveRepository, StudentRepository $studentRepository, LessonRepository $lessonRepository): Response
    {
            if ($request->isXmlHttpRequest()){
                $student = $studentRepository->findOneBy(['id' => $request->get('idStudent')]);
                $lesson = $lessonRepository->findOneBy(['id' => $request->get('idLesson')]);
                $toHave = $toHaveRepository->findOneBy(['Lessons' => $lesson, 'students' => $student]);
                $manager->remove($toHave);
                $manager->flush();
                return new Response('ok', 200);
               }
            else{
                return new Response('ko', 404);
            }

    }

}
