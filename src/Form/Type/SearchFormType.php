<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchFormType extends AbstractType
{
    public function __construct(
        
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		$nameValue = $options['name_value'];

		$builder->add('name', 'App\Form\Type\TextType', [
			'label' => 'Search',
			'data_action' => 'list#namefilter',
			'data' => $nameValue
		]);

		if($options['extraInput']){
			$options['extraInput']($builder);
		}
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'entity_id' => null,
			'url' => null,
			'column_name' => null,
			'name_value' => null,
			'extraInput' => null
        ]);

		$resolver->setRequired(['data_class', 'entity_id', 'url', 'column_name']);
    }
	
}
