<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FieldService
{
    public $entityInstance;
    public $entityMetadata;
    public $request;

    public function __construct(
        protected RequestStack $requestStack,
        protected EntityManagerInterface $entityManager)
    {
    }

    public function getEntityData($class){
        $this->request = $this->requestStack->getCurrentRequest();
        $this->entityInstance = $this->request->attributes->get('easyadmin_context')->getEntity()->getInstance();
        $this->entityMetadata = $this->entityManager->getClassMetadata($class);

    }

}