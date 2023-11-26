<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

class BaseEntity implements BaseEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[ORM\Column(type: "datetime")]
    protected \DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    protected \DateTime $modifiedAt;

    public function __construct()
    {
        $this->createdAt = new Carbon();
        $this->modifiedAt = new Carbon();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return Carbon::instance($this->createdAt);
    }

    public function getModifiedAt(): Carbon
    {
        return Carbon::instance($this->modifiedAt);
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new Carbon();
        $this->modifiedAt = new Carbon();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->modifiedAt = new Carbon();
    }
}