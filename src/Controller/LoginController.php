<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;


class LoginController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) { }

    #[Route('/login', name: 'app_login', methods: ['POST'], format: 'json')]
    public function login(Request $request): void
    {
        dd($request->toArray());
    }



}
