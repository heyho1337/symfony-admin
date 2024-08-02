<?php

declare(strict_types=1);

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class DropzoneField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null, array $fieldsConfig = [], ?int $id = null, ?string $folder = null, ?string $entity = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(FileType::class)
            ->setFormTypeOptions([
                'data_class' => null,
                'multiple' => true,
                'block_name' => 'custom_image',
                'attr' => [
                    'data-controller' => 'image',
                    'data-action' => 'change->image#change',
                    'data-id' => $id,
                    'data-folder' => $folder,
                    'data-entity' => $entity,
                    'placeholder' => 'Drag and drop or browse'
                ],
            ]);
    }
}