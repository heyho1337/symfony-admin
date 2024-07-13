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

    public function buildFormType(FormBuilderInterface $builder, string $entityClass, int $id = null): void
    {
        $metadata = $this->entityManager->getClassMetadata($entityClass);
        foreach ($metadata->fieldMappings as $field => $mapping) {
			switch($field){
				case 'createdAt':
					$disabled = true;
					break;
				case 'updatedAt':
					$disabled = true;
					break;
				default:
					$disabled = false;
			}
            if (isset($mapping['options']['formType'])) {
                $formTypeClass = $mapping['options']['formType'];
                if (class_exists($formTypeClass)) {
					switch($formTypeClass){
						case 'App\Form\Type\OnOffType':
							$builder->add($field, $formTypeClass, [
								'label' => $mapping['options']['label'] ?? '',
								'attr' => [
									'entityId' => $id
								],
							]);

							break;
						default:
							$builder->add($field, $formTypeClass, [
								'label' => $mapping['options']['label'],
								'disabled' => $disabled,
								'required' => $mapping['options']['required'] ?? false,
							]);
					}
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

