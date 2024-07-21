<?php

namespace App\Controller\Admin;

use App\Entity\EvcProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class EvcProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EvcProduct::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
		return [
            IdField::new('id')
				->hideOnForm(),
			TextEditorField::new('product_description')
				->hideOnIndex(),
			TextField::new('prodName')
				->hideOnIndex(),
            UrlField::new('prod_name','Product Name')
				->setTemplatePath('admin/fields/link_to_edit.html.twig')
				->setSortable(true)
				->hideOnForm(),
            BooleanField::new('prod_active', 'Active')
			->setSortable(true)
			->hideOnForm(),
			ChoiceField::new('prod_active', 'Active')
			->hideOnIndex()
			->setChoices([
				'Yes' => '1',
				'No' => '0',
			])
        ];
    }
    
}