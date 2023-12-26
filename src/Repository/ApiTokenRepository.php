<?php

namespace App\Repository;

use App\Entity\ApiToken;
use App\Entity\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ApiTokenRepository implements ApiTokenRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
    }
    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(ApiToken::class);
    }

    public function find(string $id): ?ApiToken
    {
        return $this->getRepository()->find($id);
    }

    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    public function save(ApiToken $token, bool $flush = true): void
    {
        $this->entityManager->persist($token);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function getTokensForUser(UserInterface $user): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $expr = $qb->expr();

        return $qb
            ->select('apiToken')
            ->where(
                $expr->eq('apiToken.user', ':userId')
            )
            ->setParameter(':userId', $user->getId())
            ->getQuery()
            ->getArrayResult();
    }
}