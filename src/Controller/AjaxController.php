<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_ajax')]
class AjaxController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('{controller}/sort/{id}/{position}', name: 'sort', methods: ['POST'])]
    public function sortAction($controller, $id, $position): JsonResponse
    {
        $repo = $this->getRepository($controller);
        $entity = $repo->{"get" . ucfirst($controller)}($id);

        $entity->setPosition($position);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true, 'result' => $entity->getPosition()]);
    }

    #[Route('{controller}/{id}/onoff', name: 'onoff', methods: ['POST'])]
    public function onoff($controller, $id): JsonResponse
    {
        $repo = $this->getRepository($controller);
        $entity = $repo->{"get" . ucfirst($controller)}($id);

        // Find the active method dynamically
        $getMethod = $this->findGetMethod($entity);
		$setMethod = $this->findSetMethod($entity);

        if ($getMethod) {
            $activeStatus = $entity->$getMethod();
			if($activeStatus == 1){
				$result = 0;
			}
			else{
				$result = 1;
			}
            $entity->$setMethod($result);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return new JsonResponse(['success' => true, 'result' => $entity->$getMethod()]);
        }

        return new JsonResponse(['success' => false, 'error' => 'Active method not found.'], 400);
    }

    private function getRepository(string $controller)
	{
		$upperName = ucfirst($controller);
		return $this->entityManager->getRepository("App\Entity\Evc{$upperName}");
	}

    private function findGetMethod($entity): ?string
    {
        $reflection = new \ReflectionClass($entity);
        foreach ($reflection->getMethods() as $method) {
            if (stripos($method->getName(), 'active') !== false) {
                return $method->getName();
            }
        }
        return null;
    }

	private function findSetMethod($entity): ?string
	{
		$reflection = new \ReflectionClass($entity);
		foreach ($reflection->getMethods() as $method) {
			if ($method->isPublic() && stripos($method->getName(), 'set') !== false && stripos($method->getName(), 'active') !== false) {
				return $method->getName();
			}
		}
		return null;
	}
}
