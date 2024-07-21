<?php

namespace App\Entity;

use App\Repository\EvcCategoryTranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\Type\TextType;

#[ORM\Entity(repositoryClass: EvcCategoryTranslationRepository::class)]
class EvcCategoryTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private ?string $trans_column = null;

    #[ORM\Column(length: 5)]
    private ?string $trans_lang = null;

    #[Assert\NotBlank]
	#[ORM\Column(type: Types::TEXT, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $trans_text = null;

    #[ORM\Column(length: 75)]
    private ?string $trans_label = null;

    #[ORM\Column(length: 75)]
    private ?string $trans_type = null;

    #[ORM\ManyToOne(inversedBy: 'category_translations')]
    private ?EvcCategory $category_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransColumn(): ?string
    {
        return $this->trans_column;
    }

    public function setTransColumn(string $trans_column): static
    {
        $this->trans_column = $trans_column;

        return $this;
    }

    public function getTransLang(): ?string
    {
        return $this->trans_lang;
    }

    public function setTransLang(string $trans_lang): static
    {
        $this->trans_lang = $trans_lang;

        return $this;
    }

    public function getTransText(): ?string
    {
        return $this->trans_text;
    }

    public function setTransText(string $trans_text): static
    {
        $this->trans_text = $trans_text;

        return $this;
    }

    public function getTransLabel(): ?string
    {
        return $this->trans_label;
    }

    public function setTransLabel(string $trans_label): static
    {
        $this->trans_label = $trans_label;

        return $this;
    }

    public function getTransType(): ?string
    {
        return $this->trans_type;
    }

    public function setTransType(string $trans_type): static
    {
        $this->trans_type = $trans_type;

        return $this;
    }

    public function getCategoryId(): ?EvcCategory
    {
        return $this->category_id;
    }

    public function setCategoryId(?EvcCategory $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }
}
