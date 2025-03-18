<?php

namespace App\Service;

use App\DTO\Request\Json\CartRequest;
use Symfony\Bundle\SecurityBundle\Security;
use Redis;

class CartService {

    private int $userId;

    public function __construct(
        private readonly Security $security,
        private readonly Redis $redis,
    )
    {
        $this->userId = $this->security->getUser()->getId();
    }

    public function getCart(): array
    {
       return $this->redis->hgetall("cart:user:$this->userId");
    }

    public function addToCart(CartRequest $cartDTO): self
    {
        $this->redis->hset("cart:user:$this->userId", $cartDTO->productId, $cartDTO->quantity);

        return $this;
    }

    public function removeFromCart($productId): self
    {
        $this->redis->del("cart:user:$this->userId", $productId);

        return $this;
    }

    public function saveCart(): void
    {
        $this->redis->expire("cart:user:$this->userId", 3600);
    }
}