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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use App\Repository\EvcCategoryRepository;
use App\Entity\EvcCategory;
class EvcProductCrudController extends AbstractCrudController
{
    public function __construct(protected EvcCategoryRepository $categRepo)
    {
        
    }
	
	public static function getEntityFqcn(): string
    {
        return EvcProduct::class;
    }

	public function configureFilters(Filters $filters): Filters
    {
		return $filters
		->add(EntityFilter::new('prod_category','Categories')
			->canSelectMultiple(true)
		)
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
		return [

			//edit page
			TextEditorField::new('product_description')
				->hideOnIndex(),
			TextField::new('prodName')
				->hideOnIndex(),
			ChoiceField::new('prod_active', 'Active')
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
			AssociationField::new('prod_category','Categories')
				->hideOnIndex()
				->autocomplete()
				->setCrudController(EvcCategoryCrudController::class),

			//index page
            IdField::new('id')
				->hideOnForm(),
            UrlField::new('prod_name','Product Name')
				->setTemplatePath('admin/fields/link_to_edit.html.twig')
				->setSortable(true)
				->hideOnForm(),
            BooleanField::new('prod_active', 'Active')
				->setSortable(true)
				->hideOnForm(),
			DateTimeField::new('createdAt','Created')
				->hideOnForm(),
			DateTimeField::new('updatedAt','Updated')
				->hideOnForm(),

			//both
			MoneyField::new('prodPrice','Price')
				->setSortable(true)
				->setCustomOption('currency', 'USD')
        ];
    }
    
}