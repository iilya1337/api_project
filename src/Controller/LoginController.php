<?php

namespace App\Controller;

use App\DTO\Request\Json\UserRequest;
use App\Service\UserService;
use App\Validate\ValidatorDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class LoginController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly UserService         $userService,
        private readonly ValidatorDTO        $validatorDTO,
    )
    {
    }

    #[Route('/login', name: 'app_login', methods: ['POST'], format: 'json')]
    public function login(): void
    {
    }

    #[Route('/registration', name: 'app_registration', methods: ['POST'], format: 'json')]
    public function registration(UserRequest $userDto): JsonResponse
    {
        $this->validatorDTO->validate($userDto);
        $user = $this->userService->saveUser($userDto);

        return $this->json($this->serializer->serialize($user, 'json', ['groups' => 'public-view']));
    }

    #[Route('/info', name: 'app_info', methods: ['GET'])]
    public function info(): Response
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        $redis->set('test', 'Hello, Redis!');
        return new Response($redis->get('test'));
    }

}
