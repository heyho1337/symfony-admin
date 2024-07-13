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

#[ORM\Entity(repositoryClass: EvcCategoryRepository::class)]
class EvcCategory
{
    
	use TimestampableEntity;

	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category_name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $category_active = null;

    #[Slug(fields: ['category_name'])]
	#[ORM\Column(length: 100, unique: true, options: ["formType" => TextType::class, 'required' => true, 'label' => 'Url'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $category_description = null;

    /**
     * @var Collection<int, EvcProduct>
     */
    #[ORM\ManyToMany(targetEntity: EvcProduct::class, mappedBy: 'prod_category')]
    private Collection $categoryProducts;

    public function __construct()
    {
        $this->categoryProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
