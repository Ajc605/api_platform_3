<?php

namespace App\ApiPlatform\Options;

use ApiPlatform\Doctrine\Orm\State\Options;
use App\Entity\User;

class UserOutputDtoOptions extends Options
{
    public function __construct(
        ?string $entityClass = null,
        mixed $handleLinks = null
    ) {
        parent::__construct(User::class, $handleLinks);
    }
}