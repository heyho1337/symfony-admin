<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\EvcCategory;
use App\Entity\EvcProduct;

class FieldService
{
    public $entityInstance;
    public $entityMetadata;
    public $request;
    public $entity;
    public $class;

    public function __construct(
        protected RequestStack $requestStack,
        protected EntityManagerInterface $entityManager)
    {
    }

    public function getEntityData(){
        $this->request = $this->requestStack->getCurrentRequest();
        $this->entity = $this->request->attributes->get('easyadmin_context')->getEntity();
        $this->class = $this->entity->GetFqcn();
        $this->entityInstance = $this->request->attributes->get('easyadmin_context')->getEntity()->getInstance();
        $this->entityMetadata = $this->entityManager->getClassMetadata($this->class);

    }

}