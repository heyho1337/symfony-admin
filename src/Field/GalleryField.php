<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;

final class GalleryField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_IMAGES = 'images';
    public const OPTION_BASE_PATH = 'basePath';

    public static function new(string $propertyName, ?string $label = null, string $folder = ''): self
    {
        $field = new self();
        $field->setProperty($propertyName);
        $field->setLabel($label);
        $field->setTemplatePath('admin/fields/gallery_custom.html.twig');
        $field->setCustomOption(self::OPTION_BASE_PATH, $folder);

        return $field;
    }
}

