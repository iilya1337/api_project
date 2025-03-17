<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    public function __construct(array $errors)
    {
        parent::__construct(400, json_encode(['errors' => $errors], JSON_THROW_ON_ERROR));
    }
}
