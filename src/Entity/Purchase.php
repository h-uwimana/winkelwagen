<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Amount = null;

    /**
     * @var Collection<int, Purchaseline>
     */
    #[ORM\OneToMany(targetEntity: Purchaseline::class, mappedBy: 'purchase')]
    private Collection $purchase;

    public function __construct()
    {
        $this->purchase = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): static
    {
        $this->Amount = $Amount;

        return $this;
    }

    /**
     * @return Collection<int, Purchaseline>
     */
    public function getPurchase(): Collection
    {
        return $this->purchase;
    }

    public function addPurchase(Purchaseline $purchase): static
    {
        if (!$this->purchase->contains($purchase)) {
            $this->purchase->add($purchase);
            $purchase->setPurchase($this);
        }

        return $this;
    }

    public function removePurchase(Purchaseline $purchase): static
    {
        if ($this->purchase->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getPurchase() === $this) {
                $purchase->setPurchase(null);
            }
        }

        return $this;
    }
}
