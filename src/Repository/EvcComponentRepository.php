<?php

// src/Repository/EvcComponentRepository.php

namespace App\Repository;

use App\Entity\EvcComponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
//use Psr\Log\LoggerInterface;
//use App\Service\CacheService;

/**
 * @extends ServiceEntityRepository<EvcComponent>
 *
 * @method EvcComponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvcComponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvcComponent[]    findAll()
 * @method EvcComponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvcComponentRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        //protected LoggerInterface $logger,
        //protected CacheService $cacheService
    ) {
        parent::__construct($registry, EvcComponent::class);
    }
    
	public function getActiveComponents(): array
    {
        return $this->findBy(['comp_active' => 1],['position' => 'ASC']);
    }

	public function getAllComponents(): array
    {
        return $this->findBy([],['position' => 'ASC']);
    }

	public function getComponent(int $id): EvcComponent
    {
		$component = $this->find($id);
		if (!$component) {
			throw $this->createNotFoundException('Component not found');
		}
		return $component;
    }
	
	/*
	public function getActiveComponents(): array
    {
        return $this->cacheService->getData("components/list", function () {
			$components = $this->findBy(['comp_active' => 1],['position' => 'ASC']);
            return $components;
        },false);
    }

	public function getComponent($id): EvcComponent
    {
        $component = $this->cacheService->getData("component/{$id}", function () use($id) {
			$component = $this->find($id);
			return $component;
        },false);
		if (!$component) {
			throw $this->createNotFoundException('Component not found');
		}
		return $component;
    }

	public function getAllComponents(): array
    {
        return $this->cacheService->getData("components/list", function () {
			$components = $this->findAll();
            return $components;
        },false);
    }
	*/
}
