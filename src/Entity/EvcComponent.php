<?php

namespace App\Entity;

use App\Repository\EvcComponentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\TextType;
use App\Form\Type\OnOffType;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: EvcComponentRepository::class)]
class EvcComponent
{
    
	use TimestampableEntity;

	#[ORM\Id]
    #[ORM\GeneratedValue]
	#[ORM\Column(options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'Id'])]
    private ?int $id = null;

	#[Assert\NotBlank]
    #[ORM\Column(length: 75, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $comp_name = null;

	#[ORM\Column(type: Types::SMALLINT,options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
	private ?int $comp_active = null;

    #[ORM\Column(length: 75, options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'app route name'])]
    private ?string $comp_alias = null;

    #[Assert\Type('int')]
	#[Assert\NotBlank]
	#[Gedmo\SortablePosition]
    #[ORM\Column(nullable: true, options: ["formType" => TextType::class, 'required' => false, 'label' => 'Order'])]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
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

	public function getPosition(): int
	{
		return $this->position;
	}

	public function setPosition(int $position): static
	{
		$this->position = $position;
		return $this;
	}
}
