<?php

namespace App\Entity;

use App\Repository\EvcProductTranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

#[ORM\Entity(repositoryClass: EvcProductTranslationRepository::class)]
class EvcProductTranslation implements TranslationInterface
{
    use TranslationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 75)]
    private ?string $prod_name = null;

    #[Assert\NotBlank]
    #[Slug(fields: ['prod_name'])]
    #[ORM\Column(length: 75)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prod_description = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProdDescription(): ?string
    {
        return $this->prod_description;
    }

    public function setProdDescription(string $prod_description): static
    {
        $this->prod_description = $prod_description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function __toString(): string
    {
        return $this->prod_name ?? '';
    }
}

