<?php

namespace App\Entity;

use App\Repository\EvcProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\OnOffType;
use App\Form\Type\MoneyType;
use Gedmo\Timestampable\Traits\TimestampableEntity;
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
	#[ORM\Column(type: 'json',length: 75, options: ["formType" => 'text', 'required' => true, 'label' => 'Name'])]
    private ?array $prod_name = [];

    #[ORM\Column(options: ["formType" => OnOffType::class, 'required' => true, 'label' => 'Active'])]
    private ?bool $prod_active = null;

    #[Assert\NotBlank]
	#[Assert\Type('float')]
	#[ORM\Column(type: 'float',options: ["formType" => MoneyType::class, 'required' => true, 'label' => 'Price'])]
    private ?float $prod_price = null;

    #[Assert\NotBlank]
	#[ORM\Column(type: 'json',length: 100, unique: true, options: ["formType" => 'text', 'required' => true, 'label' => 'Url'])]
    private ?array $prod_url = [];

    /**
     * @var Collection<int, EvcCategory>
     */
	#[Assert\Count(min:1, minMessage: 'Pls choose atleast one category')]
    #[ORM\ManyToMany(targetEntity: EvcCategory::class, inversedBy: 'categoryProducts')]
    private Collection $prod_category;

    #[ORM\Column(type: 'json', nullable: true, options: ["formType" => 'textarea', 'required' => false, 'label' => 'Description'])]
    private ?array $prod_description = [];


    public function __construct()
    {
        $this->prod_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdName(): ?array
    {
        return $this->prod_name;
    }

    public function setProdName(array $prod_name): static
    {
        $this->prod_name = $prod_name;

        return $this;
    }

    public function getProdActive(): ?bool
    {
        return $this->prod_active;
    }

    public function setProdActive(bool $prod_active): static
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

    public function getProdUrl(): ?array
    {
        return $this->prod_url;
    }

    public function setProdUrl(array $prod_url): static
    {
        $this->prod_url = $prod_url;

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

    public function getProdDescription(): ?array
    {
        return $this->prod_description;
    }

    public function setProdDescription(?array $prod_description): static
    {
        $this->prod_description = $prod_description;

        return $this;
    }
}
