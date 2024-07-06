<?php

namespace App\Entity;

use App\Repository\EvcProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvcProductRepository::class)]
class EvcProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $prod_id = null;

    #[ORM\Column(length: 75)]
    private ?string $prod_name = null;

    #[ORM\Column]
    private ?int $prod_active = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $prod_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $prod_lastmod = null;

    #[ORM\Column]
    private ?float $prod_price = null;

    #[ORM\Column(length: 75)]
    private ?string $prod_alias = null;

    public function getProdId(): ?int
    {
        return $this->prod_id;
    }

    public function setProdId(int $prod_id): static
    {
        $this->prod_id = $prod_id;

        return $this;
    }

    public function getProdName(): ?string
    {
        return $this->prod_name;
    }

    public function setProdName(string $prod_name): static
    {
        $this->prod_name = $prod_name;

        return $this;
    }

    public function getProdActive(): ?int
    {
        return $this->prod_active;
    }

    public function setProdActive(int $prod_active): static
    {
        $this->prod_active = $prod_active;

        return $this;
    }

    public function getProdCreated(): ?\DateTimeInterface
    {
        return $this->prod_created;
    }

    public function setProdCreated(\DateTimeInterface $prod_created): static
    {
        $this->prod_created = $prod_created;

        return $this;
    }

    public function getProdLastmod(): ?\DateTimeInterface
    {
        return $this->prod_lastmod;
    }

    public function setProdLastmod(\DateTimeInterface $prod_lastmod): static
    {
        $this->prod_lastmod = $prod_lastmod;

        return $this;
    }

    public function getProdPrice(): ?float
    {
        return $this->prod_price;
    }

    public function setProdPrice(float $prod_price): static
    {
        $this->prod_price = $prod_price;

        return $this;
    }

    public function getProdAlias(): ?string
    {
        return $this->prod_alias;
    }

    public function setProdAlias(string $prod_alias): static
    {
        $this->prod_alias = $prod_alias;

        return $this;
    }
}
