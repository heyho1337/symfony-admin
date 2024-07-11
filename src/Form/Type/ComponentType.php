<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\EvcComponentRepository;
use App\Service\FormService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcComponent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComponentType extends AbstractType
{
    public function __construct(
        protected EvcComponentRepository $compRepo,
        protected FormService $formService,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->formService->buildFormType($builder, EvcComponent::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvcComponent::class,
        ]);
    }
}
