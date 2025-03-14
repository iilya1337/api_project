<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class MenuRequest
{

    public function __construct(
        #[Assert\NotBlank]
        public int|string $page,

        #[Assert\NotBlank]
        public int|string $limit,
    )
    {
        $this->page = (int)$this->page;
        $this->limit = (int)$this->limit;
    }
}
