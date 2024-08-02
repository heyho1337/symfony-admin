<?php

namespace App\Controller\Admin;

use App\Entity\EvcCategory;
use App\Entity\EvcProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Form;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\UX\Dropzone\Form\DropzoneType;

class EvcCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EvcCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // Customize as needed
            ->setPageTitle(Crud::PAGE_INDEX, 'Categories')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit Category');
    }

    public function configureFields(string $pageName): iterable
    {

        if($pageName == 'edit' || $pageName == 'new') {
            $this->fieldService->getEntityData(EvcCategory::class);
            $langs = $this->fieldService->request->attributes->get('langs');
            yield FormField::addTab('Basic data');
            yield ChoiceField::new('category_active', 'Active')
                ->hideOnIndex()
                ->setChoices([
                    'Yes' => '1',
                    'No' => '0',
                ]);
            yield DateTimeField::new('createdAt', 'Created')
                ->setDisabled()
                ->hideOnIndex();
            yield DateTimeField::new('updatedAt', 'Updated')
                ->setDisabled()
                ->hideOnIndex();
            /*yield ImageField::new('prodImage', 'Image')
                ->setFormType(DropzoneType::class);
            */
            foreach ($langs as $lang) {
                $langCode = $lang->getLangCode();
                yield FormField::addTab("{$lang->getLangName()} data");
                yield TextField::new("translationData.{$langCode}_category_name", 'Name')
                    ->hideOnIndex()
                    ->setFormTypeOptions([
                        'block_name' => 'custom_text',
                    ]);
                yield TextField::new("translationData.{$langCode}_category_url", 'Url')
                    ->hideOnIndex();
                yield TextEditorField::new("translationData.{$langCode}_category_description", 'Description')
                    ->hideOnIndex();
            }
        }

        if($pageName == 'index') {

            //index page
            yield IdField::new('id')
                ->hideOnForm();
            yield UrlField::new('getCategoryNameDefault', 'Category Name')
                ->setTemplatePath('admin/fields/link_to_edit.html.twig')
                ->setSortable(true)
                ->hideOnForm();
            yield BooleanField::new('category_active', 'Active')
                ->setSortable(true)
                ->hideOnForm();
            yield DateTimeField::new('createdAt', 'Created')
                ->hideOnForm();
            yield DateTimeField::new('updatedAt', 'Updated')
                ->hideOnForm();
        }
    }
}
