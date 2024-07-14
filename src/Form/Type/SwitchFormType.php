<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\EvcCategory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwitchFormType extends AbstractType
{
    public function __construct(
        
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('category_active', 'App\Form\Type\OnOffType', [
			'label' => false,
			'attr' => [
				'entityId' => $options['entity_id'],
				'url' => $options['url']
			],
		]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvcCategory::class,
            'entity_id' => null,
			'url' => null
        ]);

		$resolver->setRequired(['data_class', 'entity_id', 'url']);
    }
	
}
