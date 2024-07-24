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
class EvcProductCrudController extends AbstractCrudController
{

    private array $langFields = [];
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EvcProductRepository $prodRepo,
        protected RequestStack $requestStack
    )
    {

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

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $langFields = [];
        $request = $this->requestStack->getCurrentRequest();
        $entityInstance = $request->attributes->get('easyadmin_context')->getEntity()->getInstance();

        if ($entityInstance) {
            $entityClass = $this->getEntityFqcn();
            $entityMetadata = $this->entityManager->getClassMetadata($entityClass);
            $fields = $entityMetadata->fieldMappings;

            foreach ($fields as $field) {
                if ($field['type'] === 'json') {
                    $fieldNameArray = explode("_", $field['fieldName']);
                    $fieldName = "get" . ucfirst($fieldNameArray[0]) . ucfirst($fieldNameArray[1]);
                    $fieldValue = $entityInstance->$fieldName();
                    $options = $field['options'];
                    $fieldClass = new \stdClass();
                    $fieldClass->type = $options['formType'];
                    $fieldClass->name = $field['fieldName'];
                    $fieldClass->label = $options['label'];
                    $fieldClass->required = $options['required'];
                    $fieldClass->id = $field['fieldName'];
                    $fieldClass->value = $fieldValue;
                    $langFields[] = $fieldClass;
                }
            }
        }
        $responseParameters->set('langFields', $langFields);
        return $responseParameters;
    }
    
    public function configureFields(string $pageName): iterable
    {

        return [

			//edit page
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
				->hideOnForm()
                ->setFormattedValue(function ($value) {
                    $data = json_decode($value, true);
                    return $data['en'];
                }),
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