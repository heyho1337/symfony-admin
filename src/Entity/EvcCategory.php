<?php

namespace App\Entity;

use App\Repository\EvcCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation\Slug;
use App\Form\Type\TextType;
use App\Form\Type\OnOffType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvcCategoryRepository::class)]
class EvcCategory
{
    
	use TimestampableEntity;

	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
	private ?int $id = null;

    #[Assert\NotBlank]
	#[ORM\Column(length: 255, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Name'])]
    private ?string $category_name = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
    private ?int $category_active = null;

    #[Slug(fields: ['category_name'])]
	#[ORM\Column(length: 100, unique: true, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Url'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $category_description = null;

    /**
     * @var Collection<int, EvcProduct>
     */
    #[ORM\ManyToMany(targetEntity: EvcProduct::class, mappedBy: 'prod_category', fetch: 'EXTRA_LAZY')]
    private Collection $categoryProducts;

	private ?int $productCount = null;

    /**
     * @var Collection<int, EvcCategoryTranslation>
     */
    #[ORM\OneToMany(targetEntity: EvcCategoryTranslation::class, mappedBy: 'category_id')]
    private Collection $category_translations;

    public function __construct()
    {
        $this->categoryProducts = new ArrayCollection();
        $this->category_translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

	public function __toString(): string
    {
        return $this->category_name; // Or any other field that provides a meaningful string representation
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): static
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getCategoryActive(): ?int
    {
        return $this->category_active;
    }

    public function setCategoryActive(int $category_active): static
    {
        $this->category_active = $category_active;

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

    public function getCategoryDescription(): ?string
    {
        return $this->category_description;
    }

    public function setCategoryDescription(?string $category_description): static
    {
        $this->category_description = $category_description;

        return $this;
    }

    /**
     * @return Collection<int, EvcProduct>
     */
    public function getCategoryProducts(): Collection
    {
        return $this->categoryProducts;
    }

    public function addCategoryProduct(EvcProduct $categoryProduct): static
    {
        if (!$this->categoryProducts->contains($categoryProduct)) {
            $this->categoryProducts->add($categoryProduct);
            $categoryProduct->addProdCategory($this);
        }

        return $this;
    }

    public function removeCategoryProduct(EvcProduct $categoryProduct): static
    {
        if ($this->categoryProducts->removeElement($categoryProduct)) {
            $categoryProduct->removeProdCategory($this);
        }

        return $this;
    }

	public function getProductCount(): ?int
                   {
                       return $this->productCount;
                   }

    public function setProductCount(?int $productCount): static
    {
        $this->productCount = $productCount;
        return $this;
    }

    /**
     * @return Collection<int, EvcCategoryTranslation>
     */
    public function getCategoryTranslations(): Collection
    {
        return $this->category_translations;
    }

    public function addCategoryTranslation(EvcCategoryTranslation $categoryTranslation): static
    {
        if (!$this->category_translations->contains($categoryTranslation)) {
            $this->category_translations->add($categoryTranslation);
            $categoryTranslation->setCategoryId($this);
        }

        return $this;
    }

    public function removeCategoryTranslation(EvcCategoryTranslation $categoryTranslation): static
    {
        if ($this->category_translations->removeElement($categoryTranslation)) {
            // set the owning side to null (unless already changed)
            if ($categoryTranslation->getCategoryId() === $this) {
                $categoryTranslation->setCategoryId(null);
            }
        }

        return $this;
    }
}
