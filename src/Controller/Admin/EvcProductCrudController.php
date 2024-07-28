<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\TranslationField;
use App\Entity\EvcProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
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
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EvcProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\FieldService;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
class EvcProductCrudController extends AbstractCrudController
{

    private array $langFields = [];
    protected FieldService $fieldService;
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EvcProductRepository $prodRepo,
        protected RequestStack $requestStack,
    )
    {
        $this->fieldService = new FieldService($this->requestStack,$this->entityManager);
    }
	
	public static function getEntityFqcn(): string
    {
        return EvcProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {

        $crud
            ->overrideTemplate('crud/edit', 'admin/product/edit.html.twig');

        return $crud;
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

        if($pageName == 'edit' || $pageName == 'new') {
            $this->fieldService->getEntityData(EvcProduct::class);
            $langs = $this->fieldService->request->attributes->get('langs');
            yield FormField::addTab('Basic data');
            yield ChoiceField::new('prod_active', 'Active')
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
            yield AssociationField::new('prod_category', 'Categories')
                ->hideOnIndex()
                ->autocomplete()
                ->setCrudController(EvcCategoryCrudController::class);
            yield MoneyField::new('prodPrice', 'Price')
                ->setSortable(true)
                ->setCustomOption('currency', 'USD')
                ->hideOnIndex();

            foreach ($langs as $lang) {
                $langCode = $lang->getLangCode();
                yield FormField::addTab("{$lang->getLangName()} data");
                yield TextField::new("translationData.{$langCode}_prod_name", 'Name')
                    ->hideOnIndex()
                    ->setFormTypeOptions([
                        'block_name' => 'custom_text',
                    ]);
                yield TextField::new("translationData.{$langCode}_prod_url", 'Url')
                    ->hideOnIndex();
                yield TextEditorField::new("translationData.{$langCode}_prod_description", 'Description')
                    ->hideOnIndex();
            }
        }

        if($pageName == 'index') {

            //index page
            yield IdField::new('id')
                ->hideOnForm();
            yield UrlField::new('getProdNameDefault', 'Product Name')
                ->setTemplatePath('admin/fields/link_to_edit.html.twig')
                ->setSortable(true)
                ->hideOnForm();
            yield BooleanField::new('prod_active', 'Active')
                ->setSortable(true)
                ->hideOnForm();
			yield DateTimeField::new('createdAt', 'Created')
                ->hideOnForm();
			yield DateTimeField::new('updatedAt', 'Updated')
                ->hideOnForm();
            yield MoneyField::new('prodPrice', 'Price')
                ->setSortable(true)
                ->setCustomOption('currency', 'USD')
                ->hideOnForm();
        }
    }

}