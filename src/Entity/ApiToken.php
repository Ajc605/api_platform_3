<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
final class ApiToken
{
    private const PERSONAL_TOKEN_PRE_FIX = 'APP_';

    #[ManyToOne(targetEntity: User::class, inversedBy: 'apiTokens')]
    private UserInterface $user;

    #[Column(type: 'datetime')]
    private \DateTime $expiresAt;

    #[Column(type: 'string', length: 68)]
    #[Id]
    private string $token;

    #[Column(type: 'json')]
    private array $scope = [];

    public function __construct(
        string $tokenType = self::PERSONAL_TOKEN_PRE_FIX
    ) {
        $this->token = sprintf('%s%s',
            $tokenType,
            bin2hex(random_bytes(32))
        );
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getScope(): array
    {
        return $this->scope;
    }

    public function setScope(array $scope): void
    {
        $this->scope = $scope;
    }
}