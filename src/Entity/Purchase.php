<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    private ?Products $product = null;

    #[ORM\ManyToOne(inversedBy: 'id')]
    private ?User $user = null;


    #[ORM\Column(length: 255)]
    private ?string $selectedSize = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }
   
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSelectedSize(): ?string
    {
        return $this->selectedSize;
    }
    
    public function setSelectedSize(string $selectedSize): self
    {
        $this->selectedSize = $selectedSize;

        return $this;
    }
}
