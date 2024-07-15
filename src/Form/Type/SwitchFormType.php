<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwitchFormType extends AbstractType
{
    public function __construct(
        
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		$builder->add($options['column_name'], 'App\Form\Type\OnOffType', [
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
            'entity_id' => null,
			'url' => null,
			'column_name' => null
        ]);

		$resolver->setRequired(['data_class', 'entity_id', 'url', 'column_name']);
    }
	
}
