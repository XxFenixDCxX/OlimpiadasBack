<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $userId = null;

    /**
     * @var Collection<int, PurchasesHistory>
     */
    #[ORM\OneToMany(targetEntity: PurchasesHistory::class, mappedBy: 'transaction')]
    private Collection $purchasesHistories;

    public function __construct()
    {
        $this->purchasesHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, PurchasesHistory>
     */
    public function getPurchasesHistories(): Collection
    {
        return $this->purchasesHistories;
    }

    public function addPurchasesHistory(PurchasesHistory $purchasesHistory): static
    {
        if (!$this->purchasesHistories->contains($purchasesHistory)) {
            $this->purchasesHistories->add($purchasesHistory);
            $purchasesHistory->setTransaction($this);
        }

        return $this;
    }

    public function removePurchasesHistory(PurchasesHistory $purchasesHistory): static
    {
        if ($this->purchasesHistories->removeElement($purchasesHistory)) {
            // set the owning side to null (unless already changed)
            if ($purchasesHistory->getTransaction() === $this) {
                $purchasesHistory->setTransaction(null);
            }
        }

        return $this;
    }
}
