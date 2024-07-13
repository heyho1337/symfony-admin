<?php

namespace App\Entity;

use App\Repository\EvcProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\SelectType;
use App\Form\Type\TextType;
use App\Form\Type\MoneyType;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation\Slug;
#[ORM\Entity(repositoryClass: EvcProductRepository::class)]
class EvcProduct
{
    
	use TimestampableEntity;

	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'Id'])]
    private ?int $id = null;

    #[ORM\Column(length: 75, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $prod_name = null;

    #[ORM\Column(options: ["formType" => SelectType::class, 'required' => true, 'label' => 'Active'])]
    private ?int $prod_active = null;

    #[ORM\Column(options: ["formType" => MoneyType::class, 'required' => true, 'label' => 'Price'])]
    private ?float $prod_price = null;

    #[Slug(fields: ['prod_name'])]
	#[ORM\Column(length: 100, unique: true, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Url'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, EvcCategory>
     */
    #[ORM\ManyToMany(targetEntity: EvcCategory::class, inversedBy: 'categoryProducts')]
    private Collection $prod_category;

    public function __construct()
    {
        $this->prod_category = new ArrayCollection();
    }

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

    public function getProdActive(): ?int
    {
        return $this->prod_active;
    }

    public function setProdActive(int $prod_active): static
    {
        $this->prod_active = $prod_active;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, EvcCategory>
     */
    public function getProdCategory(): Collection
    {
        return $this->prod_category;
    }

    public function addProdCategory(EvcCategory $prodCategory): static
    {
        if (!$this->prod_category->contains($prodCategory)) {
            $this->prod_category->add($prodCategory);
        }

        return $this;
    }

    public function removeProdCategory(EvcCategory $prodCategory): static
    {
        $this->prod_category->removeElement($prodCategory);

        return $this;
    }
}
