<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType as BaseMoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\NumberToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class MoneyType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
			'currency' => 'USD',
			'scale' => 0
        ]);
    }

    public function getParent()
    {
        return BaseMoneyType::class;
    }

    public function getBlockPrefix()
    {
        return 'custom_money';
    }

	public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['currency'] = $options['currency'];
    }

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new NumberToLocalizedStringTransformer(0, false));
    }
}
