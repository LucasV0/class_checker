<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Justify;
use App\Entity\Lesson;
use App\Entity\Period;
use App\Entity\Session;
use App\Entity\Student;
use App\Entity\ToHave;
use App\Entity\User;
use App\Repository\AbsenceRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    #[Route('/dashboard', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $period = $entityManager->getRepository(Period::class)->findOneBy(['currentPeriod' => true]);
        $users = $entityManager->getRepository(User::class)->findAll();
        $student = $entityManager->getRepository(Student::class)->findAll();
        $lessons = $entityManager->getRepository(Lesson::class)->findBy(['Period' => $period]);
        $currentUser = $this->getUser();
        $session = $entityManager->getRepository(Session::class)->findOneBy(['date' => date_create()]);
        $absences = $entityManager->getRepository(Absence::class)->findAll();
        if($session != null){
            $justification = $entityManager->getRepository(Justify::class)->findOneBy(['status' => '0']);
            $lesson = $entityManager->getRepository(Lesson::class)->findOneBy(['id' => $session->getLesson()->getId()]);
            $tohaves = $entityManager->getRepository(ToHave::class)->findBy(['Lessons' => $session->getLesson()]);
            for ($i = 0; $i < count($tohaves); $i++) {
                $status = false;
                foreach ($absences as $abs){
                    if ($abs->getSession() === $session){
                        $status = false;
                    }else{
                        $status = true;
                    }
                }
                if ($status){
                    $absence = new Absence();
                    $absence->setSession($session)
                        ->setJustify($justification)
                        ->setStudents($tohaves[$i]->getStudents())
                        ->setDateJustify(date_create());

                    $entityManager->persist($absence);
                    $entityManager->flush();
                }else{
                    break;
                }
            }
        }

        $countJustify0 = $entityManager->getRepository(Absence::class)->findByExampleField0();
        $countJustify1 = $entityManager->getRepository(Absence::class)->findByExampleField1();
        $countJustify2 = $entityManager->getRepository(Absence::class)->findByExampleField2();


        return $this->render('Partials/Dashboard.html.twig', [
            'currentUser' => $currentUser,
            'users' => $users,
            'student' => $student,
            'lesson' => $lessons,
            'absence' => $absences,
            'count_justify0' => $countJustify0,
            'count_justify1' => $countJustify1,
            'count_justify2' => $countJustify2,
        ]);
    }
    #[Route('/mdp', name: 'app_mdp')]
    public function mdp(): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $currentUser = $this->getUser();

        return $this->render('motDePasse.html.twig', [
            'currentUser' => $currentUser]);
    }
    
}


