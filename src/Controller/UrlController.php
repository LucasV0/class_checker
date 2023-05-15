<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use SymfonyComponentHttpFoundationResponse;
use SymfonyComponentRoutingAnnotationRoute;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyComponentHttpFoundationJsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use CoopTilleulsUrlSignerBundleUrlSignerUrlSignerInterface;
use SymfonyBundleFrameworkBundleControllerAbstractController;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UrlController extends AbstractController
{
    public function __construct(
        private UrlSignerInterface $urlSigner,
    )
    {
    }

    #[Route('/{id}/verification', methods: ['GET'])]
    public function newSignedUrl(string $id): Response
    {
        return new JsonResponse(['url' => $this->generateSignedUrl($id)]);
    }

    private function generateSignedUrl(string $id): string
    {
        $url = $this->generateUrl('app_user_index', ['id' => $id]);
        // Expirera après 10 secondes. PT24H
        $expiration = (new DateTime('now'))->add(new DateInterval('PT10S'));
        return $this->urlSigner->sign($url, $expiration);
    }
}
