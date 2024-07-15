<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as BaseTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
class TextType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
			'data_action' => false,
        ]);
    }

    public function getParent()
    {
        return BaseTextType::class;
    }

	public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['data_action'] = $options['data_action'];
    }

    public function getBlockPrefix()
    {
        return 'custom_text';
    }
}
