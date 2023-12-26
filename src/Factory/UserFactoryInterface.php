<?php

namespace App\Factory;

use App\Entity\UserInterface;
use App\Exceptions\Factory\UserFactoryException;

interface UserFactoryInterface
{
    public const FIRST_NAME_KEY = 'firstName';
    public const LAST_NAME_KEY = 'lastName';
    public const AGE_KEY = 'age';
    public const EMAIL_KEY = 'email';
    public const USER_KEYS = [
        self::FIRST_NAME_KEY,
        self::LAST_NAME_KEY,
        self::AGE_KEY,
    ];

    public function createUser(string $firstName, string $lastName, int $age, string $email): UserInterface;
    public function createUserWithFaker(): UserInterface;

    /**
     * @throws UserFactoryException
     */
    public function createUsers($usersData): array;
    public function createUsersWithFaker(int $numberOfUsers): array;
}