<?php

namespace App\Entity;

use App\Repository\EvcProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\OnOffType;
use App\Form\Type\TextType;
use App\Form\Type\MoneyType;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: EvcProductRepository::class)]
class EvcProduct
{
    
	use TimestampableEntity;

	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ["formType" => HiddenType::class, 'required' => true, 'label' => 'Id'])]
   	private ?int $id = null;

    #[Assert\NotBlank]
	#[ORM\Column(length: 75, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $prod_name = null;

    #[ORM\Column(options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
    private ?int $prod_active = null;

    #[Assert\NotBlank]
	#[Assert\Type('float')]
	#[ORM\Column(options: ["formType" => MoneyType::class, 'required' => true, 'label' => 'Price'])]
    private ?float $prod_price = null;

    #[Assert\NotBlank]
	#[Slug(fields: ['prod_name'])]
	#[ORM\Column(length: 100, unique: true, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Url'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, EvcCategory>
     */
	#[Assert\Count(min:1, minMessage: 'Pls choose atleast one category')]
    #[ORM\ManyToMany(targetEntity: EvcCategory::class, inversedBy: 'categoryProducts')]
    private Collection $prod_category;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prod_description = null;

    /**
     * @var Collection<int, EvcLang>
     */
    #[ORM\OneToMany(targetEntity: EvcProductTranslation::class, mappedBy: 'prod_id')]
    private Collection $product_translations;

    public function __construct()
    {
        $this->prod_category = new ArrayCollection();
        $this->product_translations = new ArrayCollection();
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

    public function getProductDescription(): ?string
    {
        return $this->prod_description;
    }

    public function setProductDescription(?string $prod_description): static
    {
        $this->prod_description = $prod_description;

        return $this;
    }

    /**
     * @return Collection<int, EvcLang>
     */
    public function getProductTranslations(): Collection
    {
        return $this->product_translations;
    }

    public function addProductTranslation(EvcLang $productTranslation): static
    {
        if (!$this->product_translations->contains($productTranslation)) {
            $this->product_translations->add($productTranslation);
            $productTranslation->setLangProduct($this);
        }

        return $this;
    }

    public function removeProductTranslation(EvcLang $productTranslation): static
    {
        if ($this->product_translations->removeElement($productTranslation)) {
            // set the owning side to null (unless already changed)
            if ($productTranslation->getLangProduct() === $this) {
                $productTranslation->setLangProduct(null);
            }
        }

        return $this;
    }
}
