<?php

// src/Repository/EvcComponentsRepository.php

namespace App\Repository;

use App\Entity\EvcComponents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use App\Service\CacheService;

/**
 * @extends ServiceEntityRepository<EvcComponents>
 *
 * @method EvcComponents|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvcComponents|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvcComponents[]    findAll()
 * @method EvcComponents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvcComponentsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        protected LoggerInterface $logger,
        protected EntityManagerInterface $entityManager,
        protected CacheInterface $cache,
        protected CacheService $cacheService
    ) {
        parent::__construct($registry, EvcComponents::class);
    }

    public function getComponents(): array
    {
        return $this->cacheService->getData("components/list", function () {
            $this->logger->info('Cache miss: Fetching data from database');
            return $this->createQueryBuilder('e')
                ->andWhere('e.comp_active = :val')
                ->setParameter('val', '1')
                ->orderBy('e.comp_sorrend', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        },false);
    }
}
