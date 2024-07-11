<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\EvcProductRepository;
use App\Service\FormService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcProduct;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function __construct(
        protected EvcProductRepository $prodRepo,
        protected FormService $formService,
        protected EntityManagerInterface $entityManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->formService->buildFormType($builder, EvcProduct::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvcProduct::class,
        ]);
    }
}
