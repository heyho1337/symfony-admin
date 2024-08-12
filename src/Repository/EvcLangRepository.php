<?php

namespace App\Repository;

use App\Entity\EvcLang;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EvcLang>
 */
class EvcLangRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvcLang::class);
    }

	public function getAllLangs(): array
    {
        return $this->findAll();
    }

	public function getLang(int $id): EvcLang
    {
		$lang = $this->find($id);
		if (!$lang) {
			throw $this->createNotFoundException('Language not found');
		}
		return $lang;
    }

	public function getActiveLangs(): array
    {
        return $this->findBy(['lang_active' => 1],[]);
    }

    //    /**
    //     * @return EvcLang[] Returns an array of EvcLang objects
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

    //    public function findOneBySomeField($value): ?EvcLang
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
