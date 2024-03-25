<?php

namespace App\Entity;

use App\Repository\UsersRepository;
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

    #[ORM\Column(nullable: true)]
    private ?int $section = null;

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

    public function getSection(): ?int
    {
        return $this->section;
    }

    public function setSection(?int $section): static
    {
        $this->section = $section;

        return $this;
    }
    public function toJson(): array
    {
    
        return [
            'id' => $this->id,
            'sub' => $this->sub,
            'section' => $this->section,
        ];
    }    
}
