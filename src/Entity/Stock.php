<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Représente un objet du stock
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Nom de l'objet
     * @ORM\Column(type="string", length=255)
     */
    private string $item;

    /**
     * Prix unitaire de l'objet
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private float $price;

    /**
     * Nombre d'objet disponible dans le stock
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private int $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Stock
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Calcule le prix total d'un objet selon sa quantité et son prix unitaire
     */
    public function calculatePrice(): float
    {
        return $this->count * $this->price;
    }
}
