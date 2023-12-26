<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity()]
#[ApiResource]
class User extends BaseEntity implements UserInterface
{
    #[ORM\Column(type: "string")]
    protected string $firstName;

    #[ORM\Column(type: "string")]
    protected string $lastName;

    #[ORM\Column(type: "integer")]
    protected int $age;

    #[ORM\Column(type: "string")]
    protected string $email;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ApiToken::class)]
    protected Collection $apiTokens;

    #[ORM\Column]
    private array $roles = [];

    public function __construct()
    {
        $this->apiTokens = new ArrayCollection();
    }

    public static function create(
        string $firstName,
        string $lastName,
        int $age,
        string $email,
    ): self
    {
        return (new self())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setAge($age)
            ->setEmail($email);
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

//    public function getApiTokens(): ArrayCollection
//    {
//        return $this->apiTokens;
//    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
