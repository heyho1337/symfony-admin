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
        //protected LoggerInterface $logger,
        //protected CacheService $cacheService,
		//protected EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, EvcProduct::class);
    }

	public function getProducts(): array
    {
		return $this->findBy(criteria: [],orderBy: ['prod_created' => 'ASC'],limit:100);
    }

    /*
	public function getProducts(): array
    {
        $products = $this->cacheService->getData("products/list", function () {
			$products = $this->findBy(criteria: [],orderBy: ['prod_created' => 'ASC'],limit:100);
            return $products;
        },false);
		return $products;
    }

	public function getProduct($id): EvcProduct
    {
        $product = $this->cacheService->getData("product/{$id}", function () use($id) {
			$product = $this->find($id);
			return $product;
        },false);
		if (!$product) {
			throw $this->createNotFoundException('Product not found');
		}
		return $product;
    }
	*/
}
