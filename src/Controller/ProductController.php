<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcProductRepository;
use App\Repository\EvcCategoryRepository;
use App\Form\Type\FormType;
use App\Service\FormService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcCategory;
use App\Entity\EvcProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Doctrine\Common\Collections\ArrayCollection;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(
		PaginatorInterface $paginator, 
		EvcProductRepository $prodRepo,
		EvcCategoryRepository $categRepo,
		#[MapQueryParameter] int $page = 1,
        #[MapQueryParameter] string $name = '',
		#[MapQueryParameter] string $sort = 'createdAt',
		#[MapQueryParameter] string $direction = 'ASC',
		#[MapQueryParameter] string $categories = '',
	): Response
    {
		
		$nameValue = $name;
		$products = $prodRepo->getProductsWithFilters($nameValue, $sort, $direction, $categories);
		$pagination = $paginator->paginate(
			$products,
			$page,
			10
		);

		$selectedCategoryIds = $categories ? explode(',', $categories) : [];
    	$categoryObject = new ArrayCollection($categRepo->findBy(['id' => $selectedCategoryIds]));

		$extraInput = fn($builder) => $this->addCategorySelectFilter($builder,$categoryObject);

		return $this->render('prod/list.html.twig', [
			'pagination' => $pagination,
			'nameValue' => $nameValue,
			'sort' => $sort,
			'direction' => $direction,
			'extraInput' => $extraInput
        ]);
    }

	#[Route('/{slug}', name: 'page')]
    public function get(
        string $slug, 
        EvcProductRepository $prodRepo, 
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->getFilters()->enable('ActiveCategory');
        $product = $prodRepo->getProductBySlug($slug);

        $form = $this->createForm(
            FormType::class, 
            $product, 
            [
                'attr' => [
                    'id' => $product->getId(),
                    'url' => '/product',
                    'classname' => EvcProduct::class,
                ],
                'extraInput' => function($builder) {
                    $this->addCategorySelect($builder);
                }
            ]
        );

        return $this->render('prod/page.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{slug}', name: 'set', methods: ['POST'])]
	public function save(
		Request $request, 
		$slug, 
		EntityManagerInterface $entityManager, 
		EvcProductRepository $prodRepo,
		EvcCategoryRepository $categRepo,
		FormService $formService
	): Response
	{
		$entityManager->getFilters()
            ->enable('ActiveCategory');

		$product = $prodRepo->getProductBySlug($slug);
		$categories = $product->getProdCategory()->toArray();

		$formService->save($request, $product, function($field, $value, $entity) use ($categories, $categRepo) {
			$this->saveUniqueData($field, $value, $entity, $categories, $categRepo);
		});

		return $this->redirectToRoute('app_prod_page', ['slug' => $slug]);
	}

	public function addCategorySelect($builder)
	{
		$builder->add('prod_category', EntityType::class, [
			'class' => EvcCategory::class,
			'choice_label' => 'categoryName',
			'label' => 'Categories',
			'disabled' => false,
			'required' => true,
			'multiple' => true,
			'expanded' => false,
			'autocomplete' => true,
			'attr' => ['data-label' => 'Categories']
		]);
	}

	public function addCategorySelectFilter($builder, ArrayCollection $categories)
	{
		
		$builder->add('prod_category', EntityType::class, [
			'class' => EvcCategory::class,
			'choice_label' => 'categoryName',
			'label' => 'Categories',
			'disabled' => false,
			'required' => true,
			'multiple' => true,
			'expanded' => false,
			'autocomplete' => true,
			'attr' => ['data-label' => 'Categories', 'data-action' => 'search#categoryfilter'],
			'data' => $categories
		]);
	}

	public function saveUniqueData(
		string $field,
		$value,
		EvcProduct $product = null,
		array $categories = [],
		EvcCategoryRepository $categRepo = null
	)
	{
		if ($field === 'prod_price') {
			$value = (float) str_replace(',', '', $value);
		}
		
		if ($field === 'prod_category' && is_array($value)) {
			foreach ($categories as $category) {
				if (!in_array($category->getId(), $value)) {
					$product->removeProdCategory($category);
				}
			}
	
			foreach ($value as $categId) {
				$category = $categRepo->find($categId);
				if ($category && !in_array($category->getId(), array_map(fn($cat) => $cat->getId(), $categories))) {
					$product->addProdCategory($category);
				}
			}
		}
	}
    
}
