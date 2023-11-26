<?php

namespace App\Factory;

use App\Entity\User;
use App\Entity\UserInterface;
use App\Exceptions\Factory\UserFactoryException;
use Faker\Factory;
use Faker\Generator;

final class UserFactory implements UserFactoryInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function createUser(string $firstName, string $lastName, int $age): UserInterface
    {
        return User::create($firstName, $lastName, $age);
    }

    public function createUserWithFaker(): UserInterface
    {
        return User::create(
            $this->faker->firstName(),
            $this->faker->lastName()    ,
            $this->faker->numberBetween(18, 99),
        );
    }

    public function createUsers($usersData): array
    {
        $users = [];

        foreach ($usersData as $userData) {
            if (!isset(
                $userData[self::FIRST_NAME_KEY],
                $userData[self::LAST_NAME_KEY],
                $userData[self::AGE_KEY],
            )) {
                throw new UserFactoryException(sprintf(
                    'Unable to create User, array must have the following keys: %s',
                    implode(',', self::USER_KEYS)
                ));
            }

            $users[] = User::create(
                $userData[self::FIRST_NAME_KEY],
                $userData[self::LAST_NAME_KEY],
                $userData[self::AGE_KEY],
            );
        }

        return $users;
    }

    public function createUsersWithFaker(int $numberOfUsers): array
    {
        $users = [];

        for ($i = 0; $i >= $numberOfUsers -1; $i++) {
            $users[] = $this->createUserWithFaker();
        }

        return $users;
    }
}