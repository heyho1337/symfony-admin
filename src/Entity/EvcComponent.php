<?php

namespace App\Entity;

use App\Repository\EvcComponentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\TextType;
use App\Form\Type\OnOffType;

#[ORM\Entity(repositoryClass: EvcComponentRepository::class)]
class EvcComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
	#[ORM\Column(options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'Id'])]
    private ?int $comp_id = null;

    #[ORM\Column(length: 75, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $comp_name = null;

	#[ORM\Column(options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
	private ?int $comp_active = null;

    #[ORM\Column(length: 75, options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'app route name'])]
    private ?string $comp_alias = null;

    #[ORM\Column(nullable: true, options: ["formType" => TextType::class, 'required' => false, 'label' => 'Order'])]
    private ?int $comp_sorrend = null;

    #[ORM\Column(length: 255, options: ["formType" => HiddenType::class, 'required' => false, 'label' => 'Alias'])]
    private ?string $comp_url = null;

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

    public function getCompUrl(): ?string
    {
        return $this->comp_url;
    }

    public function setCompUrl(string $comp_url): static
    {
        $this->comp_url = $comp_url;

        return $this;
    }
}
