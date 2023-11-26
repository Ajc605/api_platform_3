<?php

namespace App\Tests\Functional\Repository;

use App\Entity\UserInterface;
use App\Repository\UserRepositoryInterface;
use App\Tests\Utilities\KernelTestCase;
use Carbon\Carbon;

final class UserRepositoryTest extends KernelTestCase
{
    private UserRepositoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = $this->getContainer()->get(UserRepositoryInterface::class);
    }

    public function test_update_user(): void
    {
        $now = '2023-01-10 01:59:30';
        Carbon::setTestNow(new Carbon($now));

        $user = $this->sut->find(1);

        $this->assertInstanceOf(UserInterface::class, $user);

        $user->setFirstName('test');

        $this->sut->save($user);

        $this->assertSame($now, $user->getModifiedAt()->format('Y-m-d h:i:s'));
        $this->assertNotSame($now, $user->getCreatedAt()->format('Y-m-d h:i:s'));
    }
}