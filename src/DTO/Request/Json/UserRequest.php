<?php

namespace App\DTO\Request\Json;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        public string $password,
    ) { }

}
