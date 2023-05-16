<?php

namespace App\Controller;

use App\Entity\Session;
use DateTime;
use DateInterval;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class QrCodeGeneratorController extends AbstractController
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
    #[Route(methods: ['GET'])]
    private function generateSignedUrl(string $id):string
    {
        $url = $this->generateUrl('app_absence_verification', ['id' => $id]);
        // Expirera après 10 secondes. PT24H
        $expiration = (new DateTime('now'))->add(new DateInterval('PT10S'));
        return $this->urlSigner->sign($url, $expiration);
    }


    
    #[Route('/{id}/qr-codes',methods: ['GET'], name: 'app_qr_codes')]
    public function qrcode(Session $session): Response
    {
        $id = $session ->getId();
        $urlQR  = $this->generateSignedUrl($id);
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            $this->redirectToRoute('app_login');
        }
        $writer = new PngWriter();
        $qrCode = QrCode::create($urlQR)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(250)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        // $logo = Logo::create("")
        //     ->setResizeToWidth(60);
        $label = Label::create('')->setFont(new NotoSans(8));
 
        $qrCodes = [];
        // $qrCodes['img'] = $writer->write($qrCode, $logo
        // )->getDataUri();
        $qrCodes['simple'] = $writer->write(
                                $qrCode,
                                null,
                            )->getDataUri();
 
        $qrCode->setForegroundColor(new Color(255, 0, 0));
        $qrCodes['changeColor'] = $writer->write(
            $qrCode,
            null,
            $label->setText('Color Change')
        )->getDataUri();
 
        $qrCode->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 0, 0));
        $qrCodes['changeBgColor'] = $writer->write(
            $qrCode,
            null,
            $label->setText('Background Color Change')
        )->getDataUri();
 
        $qrCode->setSize(200)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));
        // $qrCodes['withImage'] = $writer->write(
        //     $qrCode,
        //     $logo,
        //     $label->setText('With Image')->setFont(new NotoSans(20))
        // )->getDataUri();
 
        return $this->render('qr_code_generator/index.html.twig', $qrCodes);
    }
}