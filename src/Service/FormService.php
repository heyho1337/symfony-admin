<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class FormService
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildFormType(FormBuilderInterface $builder, string $entityClass): void
    {
        $metadata = $this->entityManager->getClassMetadata($entityClass);
        foreach ($metadata->fieldMappings as $field => $mapping) {
            if (isset($mapping['options']['formType'])) {
                $formTypeClass = $mapping['options']['formType'];
                if (class_exists($formTypeClass)) {
                    $builder->add($field, $formTypeClass, [
                        'required' => $mapping['options']['required'] ?? false,
                        'attr' => [
                            'class' => $mapping['options']['label'] ?? ''
                        ]
                    ]);
                } else {
                    throw new \InvalidArgumentException(sprintf('Form type class "%s" does not exist.', $formTypeClass));
                }
            }
        }
		$builder->add('save', SubmitType::class, [
            'label' => 'Save',
        ]);
    }
}

