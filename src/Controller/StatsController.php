<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
use App\Repository\JustifyRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats_index')]
    public function stats(AbsenceRepository $absenceRepository): Response
    {
        $countJustify0 = $absenceRepository ->findByExampleField0();
        $countJustify1 = $absenceRepository ->findByExampleField1();
        $countJustify2 = $absenceRepository ->findByExampleField2();

        return $this->render('stats/index.html.twig', [
            'count_justify0' => $countJustify0,
            'count_justify1' => $countJustify1,
            'count_justify2' => $countJustify2,
        ]);
    }

}
