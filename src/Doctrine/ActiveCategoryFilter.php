<?php

namespace App\Doctrine;

use App\Entity\EvcCategory;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ActiveCategoryFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->getReflectionClass()->name !== EvcCategory::class) {
            return '';
        }

		return sprintf('%s.category_active = 1', $targetTableAlias);
    }
}