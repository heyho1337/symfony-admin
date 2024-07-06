<?php

namespace App\Repository;

use App\Entity\EvcLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EvcLabel>
 *
 * @method EvcLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvcLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvcLabel[]    findAll()
 * @method EvcLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvcLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvcLabel::class);
    }

    //    /**
    //     * @return EvcLabel[] Returns an array of EvcLabel objects
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

    //    public function findOneBySomeField($value): ?EvcLabel
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
