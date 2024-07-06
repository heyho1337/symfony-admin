<?php

namespace App\Repository;

use App\Entity\EvcProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use App\Service\CacheService;
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
        protected CacheService $cacheService
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
}
