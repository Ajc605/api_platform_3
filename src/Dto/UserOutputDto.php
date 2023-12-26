<?php

namespace App\Dto;

class UserOutputDto
{
    private int $id;
    private string $firstName;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
}