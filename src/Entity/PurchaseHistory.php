<?php

namespace App\Entity;

use App\Repository\PurchaseHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseHistoryRepository::class)]
class PurchaseHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'purchaseHistory')]
    private Collection $events;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'purchaseHistory')]
    private Collection $users;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Transactions $transaction = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setPurchaseHistory($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getPurchaseHistory() === $this) {
                $event->setPurchaseHistory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPurchaseHistory($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPurchaseHistory() === $this) {
                $user->setPurchaseHistory(null);
            }
        }

        return $this;
    }

    public function getTransaction(): ?Transactions
    {
        return $this->transaction;
    }

    public function setTransaction(?Transactions $transaction): static
    {
        $this->transaction = $transaction;

        return $this;
    }
}
