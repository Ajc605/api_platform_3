<?php

namespace App\Tests\integration\Repository;

use App\Entity\User;
use App\Entity\UserInterface;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserRepositoryTest extends KernelTestCase
{
    private UserRepositoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = $this->getContainer()->get(UserRepositoryInterface::class);
    }

    /**
     * @dataProvider  findUserDataProvider
     */
    public function test_find_user(
        int $id,
        array $userDetails
    ): void {
        $user = $this->sut->find($id);

        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertSame($userDetails[0], $user->getFirstName());
        $this->assertSame($userDetails[1], $user->getLastName());
        $this->assertSame($userDetails[2], $user->getAge());
    }

    public function findUserDataProvider(): iterable
    {
        yield [
            1,
            [
                'John',
                'Smith',
                37
            ]
        ];
        yield [
            2,
            [
                'Lilly',
                'Young',
                18
            ]
        ];
    }

    public function test_find_all_users(): void
    {
        $users = $this->sut->findAll();

        $user1 = $users[0];
        $user2 = $users[1];

        $this->assertInstanceOf(UserInterface::class, $user1);
        $this->assertSame('John', $user1->getFirstName());
        $this->assertSame('Smith', $user1->getLastName());
        $this->assertSame(37, $user1->getAge());
        $this->assertInstanceOf(\DateTime::class, $user1->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $user1->getModifiedAt());
        $this->assertInstanceOf(UserInterface::class, $user2);
        $this->assertSame('Lilly', $user2->getFirstName());
        $this->assertSame('Young', $user2->getLastName());
        $this->assertSame(18, $user2->getAge());
        $this->assertInstanceOf(Carbon::class, $user2->getCreatedAt());
        $this->assertInstanceOf(Carbon::class, $user2->getModifiedAt());
    }

    public function test_save_new_user(): void
    {
        $now = '2023-01-10 01:59:30';
        Carbon::setTestNow(new Carbon($now));
        $faker = Factory::create();
        $firstName = $faker->firstName();
        $lastName = $faker->lastName();
        $age = $faker->numberBetween(18, 99);

        $user = User::create($firstName, $lastName, $age);

        $this->sut->save($user);

        $this->assertSame($firstName, $user->getFirstName());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($age, $user->getAge());
        $this->assertSame($now, $user->getCreatedAt()->format('Y-m-d h:i:s'));
        $this->assertSame($now, $user->getModifiedAt()->format('Y-m-d h:i:s'));
    }
}