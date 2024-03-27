<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sub = null;

    #[ORM\ManyToMany(targetEntity: Zones::class, inversedBy: 'users')]
    private ?Collection $Zones;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    public function __construct()
    {
        $this->Zones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSub(): ?string
    {
        return $this->sub;
    }

    public function setSub(string $sub): static
    {
        $this->sub = $sub;

        return $this;
    }

    /**
     * @return Collection<int, Zones>
     */
    public function getZone(): Collection
    {
        return $this->Zones;
    }

    public function addZone(Zones $zone): static
    {
        if (!$this->Zones->contains($zone)) {
            $this->Zones->add($zone);
        }

        return $this;
    }

    public function removeZone(Zones $zone): static
    {
        $this->Zones->removeElement($zone);

        return $this;
    }    

    
    public function toArray(): array
    {
    
        return [
            'id' => $this->id,
            'sub' => $this->sub,
            'email' => $this->email,
            'zone' => $this->Zones->toArray(),
        ];
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
}
