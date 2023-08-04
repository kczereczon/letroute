<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function createNewUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);

        $passwordHashed = $this->passwordHasher->hashPassword($user, $password);

        $user->setPassword($passwordHashed);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}