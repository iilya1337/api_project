<?php

namespace App\Controller;

use App\DTO\Request\Json\UserRequest;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class LoginController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly UserService $userService,
    ) { }

    #[Route('/login', name: 'app_login', methods: ['POST'], format: 'json')]
    public function login(): void
    { }

    #[Route('/registration', name: 'app_registration', methods: ['POST'], format: 'json')]
    public function registration(UserRequest $userDto): JsonResponse
    {
        $user = $this->userService->saveUser($userDto);
        return $this->json($this->serializer->serialize($user,'json', ['groups' => 'public-view']));
    }

}
