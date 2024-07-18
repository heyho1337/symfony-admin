<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcCategoryRepository;
use App\Form\Type\FormType;
use App\Form\Type\SwitchFormType;
use Symfony\Component\Form\FormFactoryInterface;
use App\DTO\EvcCategoryExtended;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Service\FormService;
use App\Repository\EvcLangRepository;

#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractController
{

	public function __construct(
        protected EvcCategoryRepository $categRepo
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(
		PaginatorInterface $paginator, 
		FormFactoryInterface $formFactory,
		#[MapQueryParameter] int $page = 1,
        #[MapQueryParameter] string $name = '',
		#[MapQueryParameter] string $sort = 'createdAt',
		#[MapQueryParameter] string $direction = 'ASC',
	): Response
    {
		
		$nameValue = $name;
		$categories = $this->categRepo->getCategoriesWithFilters($nameValue, $sort, $direction);
		$pagination = $paginator->paginate(
			$categories,
			$page,
			10
		);

		return $this->render('category/list.html.twig', [
			'pagination' => $pagination,
			'form_factory' => $formFactory,
			'form_type' => SwitchFormType::class,
			'category_class' => EvcCategoryExtended::class,
			'nameValue' => $nameValue,
			'sort' => $sort,
			'direction' => $direction
        ]);
    }

	#[Route('/{slug}', name: 'page')]
    public function get($slug, EvcLangRepository $langRepo): Response
    {
		
		$category = $this->categRepo->getCategoryBySlug($slug);
		$langs = $langRepo->getActiveLangs();
		
		$form = $this->createForm(
			FormType::class, 
			$category, 
			['attr' => ['id' => $category->getId(), 'url' => '/category', 'classname' => \App\Entity\EvcCategory::class]],
			['data_class' => \App\Entity\EvcCategory::class]
		);
		
		return $this->render('category/page.html.twig', [
			'category' => $category,
			'form' => $form->createView(),
			'langs' => $langs
        ]);
    }

	#[Route('/set/{slug}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $slug, FormService $formService): Response
	{
		$category = $this->categRepo->getCategoryBySlug($slug);
		$formService->save($request,$category);
        return $this->redirectToRoute('app_category_page', ['slug' => $category->getSlug()]);
	}
}
