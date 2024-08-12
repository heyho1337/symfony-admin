<?php

namespace App\Controller\Admin;

use App\Entity\EvcCategory;
use App\Repository\EvcProductRepository;
use App\Service\FieldService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Form;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\HttpFoundation\RequestStack;

class EvcCategoryCrudController extends AbstractCrudController
{
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
            $this->fieldService->getEntityData();
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
