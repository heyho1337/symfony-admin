<?php

namespace App\Entity;

use App\Repository\EvcCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
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
    #[ORM\Column(type: 'json',length: 75, options: ["formType" => 'text', 'required' => true, 'label' => 'Name'])]
    private ?array $category_name = [];

    #[ORM\Column(type: Types::SMALLINT, options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
    private ?int $category_active = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'json',length: 100, unique: true, options: ["formType" => 'text', 'required' => true, 'label' => 'Url'])]
    private ?array $category_url = [];

    #[ORM\Column(type: 'json', nullable: true, options: ["formType" => 'textarea', 'required' => false, 'label' => 'Description'])]
    private ?array $category_description = [];

    /**
     * @var Collection<int, EvcProduct>
     */
    #[ORM\ManyToMany(targetEntity: EvcProduct::class, mappedBy: 'prod_category', fetch: 'EXTRA_LAZY')]
    private Collection $categoryProducts;

	private ?int $productCount = null;

    /**
     * @var Collection<int, EvcCategoryTranslation>
     */

    public function __construct()
    {
        $this->categoryProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

	public function __toString(): string
    {
        return $this->category_name['en']; // Or any other field that provides a meaningful string representation
    }

    public function getCategoryNameByLang($lang): ?string
    {
        return $this->category_name[$lang];
    }

    public function setCategoryNameByLang(string $translation, string $lang): static
    {
        $this->category_name[$lang] = $translation;

        return $this;
    }

    public function getCategoryDescriptionByLang($lang): ?string
    {
        return $this->category_description[$lang];
    }

    public function setCategoryDescriptionByLang(string $translation, string $lang): static
    {
        $this->category_description[$lang] = $translation;

        return $this;
    }

    public function getCategoryName(): ?array
    {
        return $this->category_name;
    }

    public function setCategoryName(array $category_name): static
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

    public function getCategoryDescription(): ?array
    {
        return $this->category_description;
    }

    public function setCategoryDescription(?array $category_description): static
    {
        $this->category_description = $category_description;

        return $this;
    }

    public function getCategoryUrl(): ?array
    {
        return $this->category_url;
    }

    public function setCategoryUrl(?array $category_url): static
    {
        $this->category_url = $category_url;

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
}
