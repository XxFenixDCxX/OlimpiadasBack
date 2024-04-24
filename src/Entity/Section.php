<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $slots = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Event $event = null;

    /**
     * @var Collection<int, PurchasesHistory>
     */
    #[ORM\OneToMany(targetEntity: PurchasesHistory::class, mappedBy: 'section')]
    private Collection $purchasesHistories;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function __construct()
    {
        $this->purchasesHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlots(): ?int
    {
        return $this->slots;
    }

    public function setSlots(int $slots): static
    {
        $this->slots = $slots;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @Groups({"section"})
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'slots' => $this->slots,
            'price' => $this->price,
        ];
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
            $purchasesHistory->setSection($this);
        }

        return $this;
    }

    public function removePurchasesHistory(PurchasesHistory $purchasesHistory): static
    {
        if ($this->purchasesHistories->removeElement($purchasesHistory)) {
            // set the owning side to null (unless already changed)
            if ($purchasesHistory->getSection() === $this) {
                $purchasesHistory->setSection(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
