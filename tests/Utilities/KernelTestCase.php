<?php

namespace App\Tests\Utilities;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as SymfonyKernelTestCase;

class KernelTestCase extends SymfonyKernelTestCase
{
    use RefreshDatabaseTrait;
}