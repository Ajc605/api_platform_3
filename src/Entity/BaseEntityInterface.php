<?php

namespace App\Entity;

use Carbon\Carbon;

interface BaseEntityInterface
{
    public function getId(): int;
    public function getCreatedAt(): Carbon;
    public function getModifiedAt(): Carbon;
}