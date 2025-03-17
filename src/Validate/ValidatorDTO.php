<?php

namespace App\Validate;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validation;

class ValidatorDTO {

    public function validate($dto): void
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($dto);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new ValidationException($errors);
        }
    }
}