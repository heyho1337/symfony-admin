<?php

declare(strict_types=1);

namespace App\Controller\Admin\Field;

use A2lix\TranslationFormBundle\Form\Type\TranslationsFormsType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class TranslationField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null, array $fieldsConfig = []): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(TranslationsFormsType::class)
            ->setFormTypeOptions([
                'default_locale' => 'en',
                'form_type' => TranslationsType::class
            ]);
    }
}