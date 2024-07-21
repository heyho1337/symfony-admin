<?php

namespace App\Controller\Admin;

use App\Entity\EvcCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Form;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

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
		return [

			//edit page
			TextField::new('categoryName')
				->hideOnIndex(),
			ChoiceField::new('category_active', 'Active')
				->hideOnIndex()
				->setChoices([
					'Yes' => '1',
					'No' => '0',
				]),
			DateTimeField::new('createdAt','Created')
				->setDisabled()
				->hideOnIndex(),
			DateTimeField::new('updatedAt','Updated')
				->setDisabled()
				->hideOnIndex(),

			//index page
            IdField::new('id')
				->hideOnForm(),
            UrlField::new('category_name','Category Name')
				->setTemplatePath('admin/fields/link_to_edit.html.twig')
				->setSortable(true)
				->hideOnForm(),
            BooleanField::new('category_active', 'Active')
				->setSortable(true)
				->hideOnForm(),
			DateTimeField::new('createdAt','Created')
				->hideOnForm(),
			DateTimeField::new('updatedAt','Updated')
				->hideOnForm(),
        ];
    }
}
