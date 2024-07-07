<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\EvcProductRepository;
use App\Service\FormService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcProduct;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\ActiveType;
use App\Form\Type\TextFormType;

class ProductType extends AbstractType
{
    public function __construct(
        protected EvcProductRepository $prodRepo,
        protected FormService $formService,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formTypes = [];
        $metadata = $this->entityManager->getClassMetadata(EvcProduct::class);

        foreach ($metadata->fieldMappings as $field => $mapping) {
            if (isset($mapping['options']['formType'])) {
                $formTypeClass = $mapping['options']['formType'];
                $formTypes[$field] = $mapping['options'];
				if (class_exists($formTypeClass)) {
					$builder->add($field, $formTypeClass, [
						'required' => $formTypes[$field]['required'],
						'attr' => [
							'class' => $formTypes[$field]['label']
						]
					]);
                } else {
                    throw new \InvalidArgumentException(sprintf('Form type class "%s" does not exist.', $formTypeClass));
                }
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvcProduct::class,
        ]);
    }
}
