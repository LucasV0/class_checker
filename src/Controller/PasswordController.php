<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    #[Route('/password', name: 'app_password')]
    public function edit(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
            if ($hasher->isPasswordValid($this->getUser(),$request->get('password'))) {
                if ($request->get('New') === $request->get('Confirm')) {
                    $user = $this->getUser();
                    $hashedPassword = $hasher->hashPassword($user,$request->get('New'));
                    $user->setPassword($hashedPassword);
                    $manager->persist($user);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        "Password have been change"
                    );
                    return $this->redirectToRoute('app_login');
                }else {
                    $this->addFlash(
                        'warning',
                        "New password is not correct"
                    );
                    return $this->redirectToRoute('app_mdp');
                }
                
            }else {
                    $this->addFlash(
                        'warning',
                        "Old password is not correct"
                    );
                    return $this->redirectToRoute('app_mdp');
                }
                
            
        }
}
