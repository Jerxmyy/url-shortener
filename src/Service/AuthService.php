<?php

namespace App\Service;

use App\DTO\CreateUserDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,

    ) {}
    public function registerUser(CreateUserDTO $dto): User
    {
        $user = new User();
        $user
            ->setEmail($dto->email)
            ->setDisplayName($dto->displayName)
            ->setPassword($this->passwordHasher->hashPassword($user, $dto->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}