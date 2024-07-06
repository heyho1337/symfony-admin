<?php

namespace App\Entity;

use App\Repository\EvcComponentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvcComponentsRepository::class)]
class EvcComponents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $comp_id = null;


    #[ORM\Column(length: 75)]
    private ?string $comp_name = null;

    #[ORM\Column]
    private ?int $comp_active = null;

    #[ORM\Column(length: 75)]
    private ?string $comp_alias = null;

    #[ORM\Column(nullable: true)]
    private ?int $comp_sorrend = null;

    public function getCompId(): ?int
    {
        return $this->comp_id;
    }

    public function setCompId(int $comp_id): static
    {
        $this->comp_id = $comp_id;

        return $this;
    }

    public function getCompName(): ?string
    {
        return $this->comp_name;
    }

    public function setCompName(string $comp_name): static
    {
        $this->comp_name = $comp_name;

        return $this;
    }

    public function getCompActive(): ?int
    {
        return $this->comp_active;
    }

    public function setCompActive(int $comp_active): static
    {
        $this->comp_active = $comp_active;

        return $this;
    }

    public function getCompAlias(): ?string
    {
        return $this->comp_alias;
    }

    public function setCompAlias(string $comp_alias): static
    {
        $this->comp_alias = $comp_alias;

        return $this;
    }

    public function getCompSorrend(): ?int
    {
        return $this->comp_sorrend;
    }

    public function setCompSorrend(?int $comp_sorrend): static
    {
        $this->comp_sorrend = $comp_sorrend;

        return $this;
    }
}
