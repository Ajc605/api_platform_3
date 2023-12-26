<?php

namespace App\Repository;

use App\Entity\UserInterface;

interface RepositoryInterface
{
    public function find(int $id): ?UserInterface;
    public function findAll(): array;
    public function save(UserInterface $user, bool $flush = true): void;
}