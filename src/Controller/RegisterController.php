<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Wallet;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, private Security $security)
    {
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'register')]
    public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->findOneBy(['email' => $data['email']]);
        if ($user) {
            return new JsonResponse(['error' => 'Email already used'], Response::HTTP_BAD_REQUEST);
        }
        $user = new \App\Entity\User();
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setRoles([]);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTime());
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(['success' => 'User created'], Response::HTTP_CREATED);
    }

    #[Route('/api/register_children', name:'register_children')]
    public function registerChildren(Request $request,EntityManagerInterface $entityManager, UserRepository $userRepository, WalletRepository $walletRepository): JsonResponse
    {
        $parent = $userRepository->find($this->getUser()->getId());
        $data = json_decode($request->getContent(), true);
        $wallet = new Wallet();
        $wallet->setPoints(0);
        $entityManager->persist($wallet);

        $contract = new Contract();
        $contract->setParent($parent);
        $contract->setDescription('contract description');
        $contract->setRatioMoney(0.5);
        $contract->setPointBonus(5);
        $contract->setCreatedAt(new \DateTimeImmutable());
        $contract->setStatus(Contract::$DRAFT);


        $user = new \App\Entity\User();
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setParent($parent);
        $wallet->setUser($user);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTime());
        $entityManager->persist($user);
        $contract->setUser($user);
        $entityManager->persist($contract);
        $entityManager->persist($wallet);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Children created'], Response::HTTP_CREATED);
    }

    // #[Route('/api/test', name:'test', methods: ['POST'])]
    // public function test($username = 'user', $password = 'password')
    // {
    //     // $this->getUser()->getEmail();
    //     return new JsonResponse([
    //         'test' => $this->security->getUser(),
    //     ]);
    // }
}
