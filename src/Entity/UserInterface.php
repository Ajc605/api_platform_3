<?php

namespace App\Entity;

interface UserInterface extends BaseEntityInterface
{
    public function getFirstName(): string;
    public function setFirstName(string $firstName): static;
    public function getLastName(): string;
    public function setLastName(string $lastName): static;
    public function getAge(): int;
    public function setAge(int $age): static;
}