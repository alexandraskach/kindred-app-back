<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\JsonResponseFactory;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class UserController extends AbstractController
{

    public function __construct(private JsonResponseFactory $jsonResponseFactor)
    {
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        dd($this->getUser());
        return $this->jsonResponseFactor->create();
    }
}
