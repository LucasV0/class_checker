<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UrlController extends AbstractController
{
    public function __construct(
        private UrlSignerInterface $urlSigner,
    )
    {
    }
    #[Route('/{id}/verification',name: 'app_url', methods: ['GET'])]
    public function generateSignedUrl(string $id):string
    {
        $url = $this->generateUrl('app_absence_verification', ['id' => $id]);
        // Expirera après 10 secondes. PT24H
        $expiration = (new DateTime('now'))->add(new DateInterval('PT10S'));
        return  $this->urlSigner->sign($url, $expiration);
    }


}
