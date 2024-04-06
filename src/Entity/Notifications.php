<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
class Notifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Subject = null;

    #[ORM\Column(length: 255)]
    private ?string $ShortText = null;

    #[ORM\Column(length: 255)]
    private ?string $LongMessage = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?Users $users = null;

    #[ORM\Column]
    private ?bool $isReaded = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(string $Subject): static
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getShortText(): ?string
    {
        return $this->ShortText;
    }

    public function setShortText(string $ShortText): static
    {
        $this->ShortText = $ShortText;

        return $this;
    }

    public function getLongMessage(): ?string
    {
        return $this->LongMessage;
    }

    public function setLongMessage(string $LongMessage): static
    {
        $this->LongMessage = $LongMessage;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->Subject,
            'short_text' => $this->ShortText,
            'long_message' => $this->LongMessage,
            'is_readed' => $this->isReaded
        ];
    }

    public function isIsReaded(): ?bool
    {
        return $this->isReaded;
    }

    public function setIsReaded(bool $isReaded): static
    {
        $this->isReaded = $isReaded;

        return $this;
    }
}
