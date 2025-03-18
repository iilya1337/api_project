<?php

namespace App\DTO\Request\Json;

use Symfony\Component\Validator\Constraints as Assert;

class CartRequest
{
    public function __construct(
        #[Assert\NotBlank]
        public int $productId,

        #[Assert\NotBlank]
        public int $quantity = 1
    ) { }
}