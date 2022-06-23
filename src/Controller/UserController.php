<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public UserPasswordHasherInterface $passwordHasher;

    public function __construct(private Security $security, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function new(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        
        $user = $userRepository->findOneBy(['email' => $data['email']]);
        if ($user) return new JsonResponse(['error' => 'Email already used'], Response::HTTP_BAD_REQUEST);


        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_USER']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTime());

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['success' => 'User created'], Response::HTTP_CREATED);
    }

    public function current()
    {
        $userId = $this->getUser() ? $this->getUser()->getId() : null;

        return new JsonResponse($userId);
    }
}
