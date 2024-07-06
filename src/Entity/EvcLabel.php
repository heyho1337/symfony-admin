<?php

namespace App\Entity;

use App\Repository\EvcLabelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvcLabelRepository::class)]
class EvcLabel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $label_id = null;


    #[ORM\Column(length: 75)]
    private ?string $label_name = null;

    #[ORM\Column(length: 75)]
    private ?string $label_value = null;

    public function getLabelId(): ?int
    {
        return $this->label_id;
    }

    public function getLabelName(): ?string
    {
        return $this->label_name;
    }

    public function setLabelName(string $label_name): static
    {
        $this->label_name = $label_name;

        return $this;
    }

    public function getLabelValue(): ?string
    {
        return $this->label_value;
    }

    public function setLabelValue(string $label_value): static
    {
        $this->label_value = $label_value;

        return $this;
    }
}
