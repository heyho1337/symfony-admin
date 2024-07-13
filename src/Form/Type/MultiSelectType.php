<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MultiSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
			'label' => false,
			'autocomplete' => true,
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }

	public function getBlockPrefix()
    {
        return 'custom_multiselect';
    }
}