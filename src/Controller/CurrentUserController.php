<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class CurrentUserController extends AbstractController
{
    public function __construct(private Security $security) {}
    public function __invoke(): UserInterface
    {
        return $this->security->getUser();
    }

    public function test()
    {
        // var_dump($this->getUser()->getId());
        // die;
        // dd(json_encode($this->getUser()));
    }
}
