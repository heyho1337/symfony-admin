<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class FormService extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
       
    }

    public function buildFormType(FormBuilderInterface $builder, string $entityClass, int $id = null, string $url = null, callable $extraInput = null): void
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
									'entityId' => $id,
									'url' => $url
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
		if($extraInput){
			$extraInput($builder);
		}
		
		$builder->add('save', SubmitType::class, [
            'label' => 'Save',
        ]);
    }

	public function save($request, $entity, $setmethods = null): bool
	{
		$data = $request->request->all();

		foreach ($data['form'] as $field => $value) {
			$method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
			
			if ($setmethods) {
				$setmethods($field, $value, $entity);
			}
			
			if (method_exists($entity, $method)) {
				$entity->$method($value);
			}
		}
		
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

		$this->addFlash('notice','Saved successfully');
		return true;
	}
}

