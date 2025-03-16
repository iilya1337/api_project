<?php

namespace App\Controller;

use App\DTO\Request\DishRequest;
use App\DTO\Request\MenuRequest;
use App\Service\MenuService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/menu')]
class MenuController extends AbstractController
{
    public function __construct(
        private readonly MenuService $menuService
    ) { }

    #[Route(name: 'app_menu', methods: ['GET'])]
    public function menu(MenuRequest $menuRequest): JsonResponse
    {
        return $this->json([
            "data" => $this->menuService->getMenu($menuRequest),
        ]);
    }

    #[Route('/dish/{id}', name: 'app_menu_dis', methods: ['GET'])]
    public function dis(DishRequest $dish): JsonResponse
    {
        return $this->json($dish);
    }

    #[Route('/dish/{id}', name: 'app_menu_dish', methods: ['GET'])]
    public function dish(DishRequest $dish): JsonResponse
    {
        return $this->json($dish);
    }



}
