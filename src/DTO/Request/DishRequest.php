<?php

namespace App\DTO\Response;

use App\Entity\Dish;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use JsonSerializable;

class DishResponse implements JsonSerializable
{

    public function __construct(

        private readonly ?Dish $dish,
        private ?ConstraintViolationListInterface $errors = null,
    )
    {
        $this->validate();
    }

    public function validate(): void
    {
        $this->errors = Validation::createValidator()->validate($this->dish, [new Assert\NotNull(message: "Dish does not exist")]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        if (count($this->errors) > 0) {
            return ['error' => $this->errors[0]->getMessage()];
        }

        return [
            'id' => $this->dish->getId(),
            'name' => $this->dish->getName(),
            'description' => $this->dish->getDescription(),
            'price' => $this->dish->getPrice(),
        ];
    }
}
