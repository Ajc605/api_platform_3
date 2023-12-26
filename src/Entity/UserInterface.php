<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UserInterface extends BaseEntityInterface, SymfonyUserInterface
{
    public function getFirstName(): string;
    public function setFirstName(string $firstName): static;
    public function getLastName(): string;
    public function setLastName(string $lastName): static;
    public function getAge(): int;
    public function setAge(int $age): static;
    public function getEmail(): string;
    public function setEmail(string $lastName): static;
}