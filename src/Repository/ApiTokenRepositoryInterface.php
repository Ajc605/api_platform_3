<?php

namespace App\Repository;

use App\Entity\ApiToken;
use App\Entity\UserInterface;

interface ApiTokenRepositoryInterface
{
    public function getTokensForUser(UserInterface $user): array;
    public function find(string $id): ?ApiToken;
    public function findAll(): array;
    public function save(ApiToken $token, bool $flush = true): void;
}