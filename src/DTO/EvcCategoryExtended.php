<?php

namespace App\DTO;

class EvcCategoryExtended
{

    public function __construct(
		public int $id, 
		public string $categoryName, 
		public int $categoryActive, 
		public string $slug, 
		public ?string $categoryDescription, 
		public int $productCount)
    {
        
    }

	public function getCategoryActive(): int
    {
        return $this->categoryActive;
    }

    // Getter methods for each property...
}
