<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiveType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
			'label' => false,
            'choices' => [
				'Please select one' => '',
                'Yes' => 1,
                'No' => 0,
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

	public function getBlockPrefix()
    {
        return 'custom_active';
    }
}