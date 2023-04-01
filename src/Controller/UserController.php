<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/adminList.html.twig', [
            'users' => $userRepository->findAll()
        ]);
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

    #[Route('/admin/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('admin_users');
    }
}
