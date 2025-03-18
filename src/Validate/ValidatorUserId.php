<?php

namespace App\Validate;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidatorUserId
{
    public function __construct(
        private readonly Security $security,
    ) { }

    public function validate($userId): void
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser || $currentUser->getId() != $userId) {
            throw new BadRequestHttpException(json_encode([
                "error" => "User ID does not belong to the authenticated user."
            ]));
        }
    }
}