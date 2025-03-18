<?php

namespace App\Controller;

use App\DTO\Request\Json\CartRequest;
use App\Service\CartService;
use App\Validate\ValidatorUserId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/user')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService         $cartService,
        private readonly SerializerInterface $serializer,

    ) { }

    #[Route('/getCart', name: 'app_cart', methods: ['GET'], format: 'json')]
    public function getCart(): JsonResponse
    {
        return $this->json($this->serializer->serialize($this->cartService->getCart(), 'json'));
    }

    #[Route('/addItem', name: 'app_add_item', methods: ['POST'], format: 'json')]
    public function addToCart(CartRequest $cartDTO): JsonResponse
    {
        $this->cartService->addToCart($cartDTO)->saveCart();
        return $this->json(['message' => 'Product added to cart successfully.']);
    }

    #[Route('/deleteItem/{id}', name: 'app_delete_item', methods: ['DELETE'], format: 'json')]
    public function removeFromCart(int $id): JsonResponse
    {
        $this->cartService->removeFromCart($id)->saveCart();
        return $this->json(['message' => 'Product removed from cart successfully.']);
    }
}