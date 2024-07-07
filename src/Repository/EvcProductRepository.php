<?php

namespace App\Repository;

use App\Entity\EvcProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use App\Service\CacheService;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @extends ServiceEntityRepository<EvcProduct>
 *
 * @method EvcProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvcProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvcProduct[]    findAll()
 * @method EvcProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvcProductRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        protected LoggerInterface $logger,
        protected CacheService $cacheService,
		protected EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, EvcProduct::class);
    }

    public function getProducts(): array
    {
        return $this->cacheService->getData("products/list", function () {
            return $this->createQueryBuilder('e')
                ->orderBy('e.prod_created', 'ASC')
                ->setMaxResults(100)
                ->getQuery()
                ->getResult();
        },false);
    }

	public function getProduct($id): array
    {
        return $this->cacheService->getData("product/{$id}", function () use($id) {
            $product = $this->createQueryBuilder('e')
				->andWhere('e.prod_id = :val')
				->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult();
			$formTypes = [];
			$metadata = $this->entityManager->getClassMetadata(EvcProduct::class);
			foreach ($metadata->fieldMappings as $field => $mapping) {
				$formTypes[$field] = $mapping['options'] ?? null;
			}
		
			return [
				'product' => $product,
				'formTypes' => $formTypes,
			];
        },false);
    }
}
