<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles() != ['ROLE_ADMIN', 'ROLE_USER']){
            return $this->redirectToRoute('app_home');
        }
        $currentUser = $this->getUser();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'currentUser' => $currentUser,
    
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles() != ['ROLE_ADMIN', 'ROLE_USER']){
            return $this->redirectToRoute('app_home');
        }
        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $secret = $authenticator->generateSecret();
            $plainPassword = $form->get('MotDePasse')->getData();
            $hashPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashPassword);
                // ->setGoogleAuthenticatorSecret($secret);
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles() != ['ROLE_ADMIN', 'ROLE_USER']){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser()->getRoles() != ['ROLE_ADMIN', 'ROLE_USER']){
            return $this->redirectToRoute('app_home');
        }
        $currentUser = $this->getUser();
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/editProfile/{id}', name: 'app_user_editProfil', methods: ['POST'])]
    public function editProfil(Request $request, User $user, UserRepository $userRepository ): JsonResponse|Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $json = [];
        if($request->isXmlHttpRequest() || $request->query->get('showJson') === 1){
            $user->setNom($request->get('nom'))
                ->setPrenom($request->get('prenom'))
                ->setEmail($request->get('email'))
                ->setDateNaissance(date_create($request->get('dateNaissance')))
                ->setTelephone($request->get('tel'))
                ->setSexe($request->get('sexe'));
            if($userRepository->save($user, true)){
                $json = ['response' => 'ok'];
            }else{
                $json = ['response' => 'ko'];
            }            
        }else {
            $json = ['response' => 'ko'];
        }
        return new JsonResponse($json);
    }

    #[Route('/delete/{id}', name: 'app_user_delete', methods: ['GET'])]
    public function delete(Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
            $currentUser = $this->getUser();

            if (!$user) {
                $this->addFlash(
                    'warning',
                    "Le cour n'a pas été trouvé!"
                );
                return $this->redirectToRoute('app_user_index');
            }
    
            $manager->remove($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le professeur à été supprimé avec succès !'
            );
            return $this->redirectToRoute('app_user_index', ['currentUser' => $currentUser,]);

        
    }
    #[Route('/profil/{id}', name: 'app_profil', methods:['GET'])]
    public function profil(): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $currentUser = $this->getUser();
        return $this->render('user/Profile.html.twig', ['currentUser' => $currentUser,]);
    }
    }

