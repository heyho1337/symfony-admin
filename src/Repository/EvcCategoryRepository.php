<?php

namespace App\Repository;

use App\Entity\EvcCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\EvcCategoryExtended;

/**
 * @extends ServiceEntityRepository<EvcCategory>
 */
class EvcCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvcCategory::class);
    }

	public function getRandomCategories(){
		$count = $this->count([]);
		$limit = rand(1, 5);
		$offset = rand(0, max(0, $count - $limit));
		
		return $this->createQueryBuilder('category')
			->setMaxResults($limit)
			->setFirstResult($offset)
			->getQuery()
			->getResult();
	}

	public function getCategories(): array
    {
		return $this->findBy(criteria: [],orderBy: ['createdAt' => 'ASC']);
    }

	public function getExtendedCategories(): array
	{

		$result = $this->createQueryBuilder('category')
            ->select(sprintf(
                'NEW %s(
                    category.id,
					category.category_name,
					category.category_active,
					category.slug,
					category.category_description,
					COUNT(Product.id)
                )',
                EvcCategoryExtended::class
            ))
			->leftJoin('category.categoryProducts', 'Product')
        	->groupBy('category.id')
        	->orderBy('category.createdAt', 'ASC')
			->getQuery()
			->getResult();
		
		return $result;
	}

	public function getCategoriesWithFilters(string $name = null, string $sort, string $direction): array
    {
		$query =  $this->createQueryBuilder('category')
		->select(sprintf(
			'NEW %s(
				category.id,
				category.category_name,
				category.category_active,
				category.slug,
				category.category_description,
				COUNT(Product.id)
			)',
			EvcCategoryExtended::class
		))
		->leftJoin('category.categoryProducts', 'Product')
		->groupBy('category.id');

		if($name != null){
			$nameArray = explode(" ",$name);
			$query
				->andWhere('category.category_name LIKE :name OR category.category_name IN (:nameArray) OR category.category_description LIKE :name')
				->setParameter('nameArray', $nameArray)
				->setParameter('name', '%' . $name . '%');
		}

		$query
			->orderBy('category.'.$sort, $direction);

		return $query->getQuery()->getResult();
    }

	public function getActiveCategories(): array
    {
        return $this->findBy(['category_active' => 1]);
    }

	public function getCategoryBySlug(string $slug): EvcCategory
    {
		$category = $this->createQueryBuilder('category')
            ->leftJoin('category.category_translations', 'translation')
            ->addSelect('translation')
            ->where('category.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
			->getOneOrNullResult();
		
		if (!$category) {
			throw $this->createNotFoundException('Category not found');
		}
		return $category;
    }

	public function getCategory(int $id): EvcCategory
    {
		$category = $this->find($id);
		if (!$category) {
			throw $this->createNotFoundException('Category not found');
		}
		return $category;
    }

    //    /**
    //     * @return EvcCategory[] Returns an array of EvcCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EvcCategory
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
