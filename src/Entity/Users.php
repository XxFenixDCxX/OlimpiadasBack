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
    private ?Collection $Zone;

    public function __construct()
    {
        $this->Zone = new ArrayCollection();
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
        return $this->Zone;
    }

    public function addZone(Zones $zone): static
    {
        if (!$this->Zone->contains($zone)) {
            $this->Zone->add($zone);
        }

        return $this;
    }

    public function removeZone(Zones $zone): static
    {
        $this->Zone->removeElement($zone);

        return $this;
    }    

    
    public function toArray(): array
    {
    
        return [
            'id' => $this->id,
            'sub' => $this->sub,
            'zone' => $this->Zone->toArray(),
        ];
    }
}
