<?php

namespace App\Tests\unit\Factory;

use App\Entity\UserInterface;
use App\Exceptions\Factory\UserFactoryException;
use App\Factory\UserFactory;
use App\Factory\UserFactoryInterface;
use PHPUnit\Framework\TestCase;

final class UserFactoryTest extends TestCase
{
    private UserFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new UserFactory();
    }

    public function test_create_user(): void
    {
        $firstName = 'John';
        $lastName = 'smith';
        $age = 37;

        $user = $this->sut->createUser(
            $firstName,
            $lastName,
            $age
        );

        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
    }

    public function test_create_user_with_faker(): void
    {
        $user = $this->sut->createUserWithFaker();

        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertIsString($user->getFirstName());
        $this->assertIsString($user->getLastName());
        $this->assertIsInt($user->getAge());
    }

    /**
     * @dataProvider createUsersThroesUserFactoryExceptionDataProvider
     */
    public function test_creat_users_throws_user_factory_exception(
        array $users
    ): void {
        $this->expectException(UserFactoryException::class);

        $this->sut->createUsers($users);
    }

    public function createUsersThroesUserFactoryExceptionDataProvider(): iterable
    {
        yield [
            [
                UserFactoryInterface::LAST_NAME_KEY,
                UserFactoryInterface::AGE_KEY,
            ]
        ];
        yield [
            [
                UserFactoryInterface::FIRST_NAME_KEY,
                UserFactoryInterface::AGE_KEY,
            ]
        ];
        yield [
            [
                UserFactoryInterface::FIRST_NAME_KEY,
                UserFactoryInterface::LAST_NAME_KEY,
            ]
        ];
    }

    /**
     * @dataProvider createUsersDataProvider
     */
    public function test_creat_user(
        array $users
    ): void {
        $createdUser = $this->sut->createUsers($users);

        $this->assertSame(
            count($users),
            count($createdUser)
         );

         for ($i = 0; $i >= count($users) - 1; $i++) {
            $user = $createdUser[$i];

            $this->assertInstanceOf(UserInterface::class, $user);
            $this->assertSame($users[$i][UserFactoryInterface::FIRST_NAME_KEY], $user->getFirstName());
            $this->assertSame($users[$i][UserFactoryInterface::LAST_NAME_KEY], $user->getLastnName());
            $this->assertSame($users[$i][UserFactoryInterface::AGE_KEY], $user->getAge());
         }
    }

    public function createUsersDataProvider(): iterable
    {
        yield [
            [
                [
                    UserFactoryInterface::FIRST_NAME_KEY => 'John',
                    UserFactoryInterface::LAST_NAME_KEY => 'Smith',
                    UserFactoryInterface::AGE_KEY => 38,
                ],
                [
                    UserFactoryInterface::FIRST_NAME_KEY => 'Lilly',
                    UserFactoryInterface::LAST_NAME_KEY => 'Young',
                    UserFactoryInterface::AGE_KEY => 18,
                ],
                [
                    UserFactoryInterface::FIRST_NAME_KEY => 'Joe',
                    UserFactoryInterface::LAST_NAME_KEY => 'Blogs',
                    UserFactoryInterface::AGE_KEY => 25,
                ],
            ]
        ];
    }
}