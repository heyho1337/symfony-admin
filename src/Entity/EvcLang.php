<?php

namespace App\Entity;

use App\Repository\EvcLangRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\TextType;
use App\Form\Type\OnOffType;

#[ORM\Entity(repositoryClass: EvcLangRepository::class)]
class EvcLang
{
    use TimestampableEntity;
	
	#[ORM\Id]
	#[ORM\GeneratedValue]
    #[ORM\Column(options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'Id'])]
	private ?int $id = null;

    #[Assert\NotBlank]
	#[ORM\Column(length: 75, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $lang_name = null;

	#[Assert\NotBlank]
    #[ORM\Column(length: 5, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Code'])]
    private ?string $lang_code = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
    private ?int $lang_active = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangName(): ?string
    {
        return $this->lang_name;
    }

    public function setLangName(string $lang_name): static
    {
        $this->lang_name = $lang_name;

        return $this;
    }

    public function getLangCode(): ?string
    {
        return $this->lang_code;
    }

    public function setLangCode(string $lang_code): static
    {
        $this->lang_code = $lang_code;

        return $this;
    }

    public function getLangActive(): ?int
    {
        return $this->lang_active;
    }

    public function setLangActive(int $lang_active): static
    {
        $this->lang_active = $lang_active;

        return $this;
    }

    public function getLangProduct(): ?EvcProduct
    {
        return $this->lang_product;
    }

    public function setLangProduct(?EvcProduct $lang_product): static
    {
        $this->lang_product = $lang_product;

        return $this;
    }
}
