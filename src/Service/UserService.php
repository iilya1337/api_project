<?php

namespace App\Service;

use App\DTO\Request\Json\UserRequest;
use App\Entity\User;
use App\Validate\ValidatorDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserService {

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ValidatorDTO $validatorDTO,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) { }

    public function saveUser(UserRequest $userDto): User
    {
        $this->validatorDTO->validate($userDto);

        $user = new User;

        $user->setEmail($userDto->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $userDto->password));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    private function hashPassword($user): string
    {
        return $this->passwordHasher->hashPassword($user, $user->password);
    }

}
