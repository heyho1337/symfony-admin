<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Service\FormService;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
	protected $className = "";

    public function __construct(
        protected FormService $formService,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->className = $options['attr']['classname'];
		$this->formService->buildFormType($builder, $this->className, $options['attr']['id'], $options['attr']['url']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
    }
}
