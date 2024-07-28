<?php
namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TranslatedTextField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {

        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/text_custom.html.twig')
            ->setFormType(TextType::class)
            ->setValue("aaa")
            ->setFormattedValue("bbbb")
            ->formatValue(function (){
                return "ccc";
            });
    }
}


