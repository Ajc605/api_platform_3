<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    /**
     * @dataProvider createUserDataProvider
     */
    public function test_create_user(
        string $firstName,
        string $lastName,
        int $age,
    ): void {
        $user = (new User())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setAge($age);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
    }

    /**
     * @dataProvider createUserDataProvider
     */
    public function test_create_user_with_create_static_function(
        string $firstName,
        string $lastName,
        int $age,
        string $email,
    ): void {
        $user = User::create($firstName, $lastName, $age, $email);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
    }

    public function test_user_setters(): void {
        $firstName = 'John';
        $lastName = 'Smith';
        $age = 20;
        $email = 'email';
        $newFirstName = 'Lilly';
        $newLastName = 'Young';
        $newAge = 18;
        $newEmail = 'New@email';

        $user = User::create($firstName, $lastName, $age, $email);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
        $this->assertSame($email, $user->getEmail());

        $user->setFirstName($newFirstName)
            ->setLastName($newLastName)
            ->setAge($newAge)
            ->setEmail($newEmail);

        $this->assertSame($newFirstName, $user->getFirstName());
        $this->assertSame($newLastName, $user->getLastName());
        $this->assertSame($newAge, $user->getAge());
        $this->assertSame($newEmail, $user->getEmail());
    }

    public function createUserDataProvider(): iterable
    {
        yield [
            'John',
            'smith',
            37,
            'email',
        ];
        yield [
            'Lilly',
            'smith',
            35,
            'email',
        ];
    }
}