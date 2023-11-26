<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity()]
class User extends BaseEntity implements UserInterface
{
    #[ORM\Column(type: "string")]
    protected string $firstName;

    #[ORM\Column(type: "string")]
    protected string $lastName;

    #[ORM\Column(type: "integer")]
    protected int $age;

    public static function create(
         string $firstName,
         string $lastName,
         int $age,
    ): self {
        return (new self())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setAge($age);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }
}