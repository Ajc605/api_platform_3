<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }

    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    public function find(int $id): ?UserInterface
    {
        return $this->getRepository()->find($id);
    }

    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    public function save(UserInterface $user, bool $flush = true): void
    {
        $this->entityManager->persist($user);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}