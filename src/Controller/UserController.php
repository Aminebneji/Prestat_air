<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/{email}', name: 'user_detail')]
    public function showOne(UserRepository $userRepository, string $email): Response
    {
        return $this->render('user/detail.html.twig', [
            'user' => $userRepository->findOneBy(['email' => $email])
        ]);
    }

    #[Route('/research/all', name: 'showAllUser')]
    public function showAllUser(UserRepository $userRepository): Response
    {
        return $this->render('user/showAllUser.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }
}
