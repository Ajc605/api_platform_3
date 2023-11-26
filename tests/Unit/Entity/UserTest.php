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
    ): void {
        $user = User::create($firstName, $lastName, $age);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
    }

    public function test_user_setters(): void {
        $firstName = 'John';
        $lastName = 'Smith';
        $age = 20;
        $newFirstName = 'Lilly';
        $newLastName = 'Young';
        $newAge = 18;

        $user = User::create($firstName, $lastName, $age);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());

        $user->setFirstName($newFirstName)
            ->setLastName($newLastName)
            ->setAge($newAge);

        $this->assertSame($newFirstName, $user->getFirstName());
        $this->assertSame($newLastName, $user->getLastName());
        $this->assertSame($newAge, $user->getAge());
    }

    public function createUserDataProvider(): iterable
    {
        yield [
            'John',
            'smith',
            37,
        ];
        yield [
            'Lilly',
            'smith',
            35,
        ];
    }
}