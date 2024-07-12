<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OnOffType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
			'label' => false,
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

	public function getBlockPrefix()
    {
        return 'custom_onoff';
    }
}