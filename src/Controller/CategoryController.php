<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\FormType;
use App\Form\Type\SwitchFormType;
use App\Form\Type\ProductType;
use Symfony\Component\Form\FormFactoryInterface;
use App\DTO\EvcCategoryExtended;

#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractController
{

	#[Route('', name: 'list')]
    public function list(
		Request $request, 
		PaginatorInterface $paginator, 
		EvcCategoryRepository $categRepo,
		FormFactoryInterface $formFactory
	): Response
    {
		
		$categories = $categRepo->getExtendedCategories();
		$pagination = $paginator->paginate(
			$categories,
			$request->query->getInt('page', 1),
			10
		);

		return $this->render('category/list.html.twig', [
			'pagination' => $pagination,
			'form_factory' => $formFactory,
			'form_type' => SwitchFormType::class,
			'category_class' => EvcCategoryExtended::class
        ]);
    }

	#[Route('/{slug}', name: 'page')]
    public function get($slug, EvcCategoryRepository $categRepo, EntityManagerInterface $entityManager): Response
    {
		
		$category = $categRepo->getCategoryBySlug($slug);
		
		$form = $this->createForm(
			FormType::class, 
			$category, 
			['attr' => ['id' => $category->getId(), 'url' => '/category', 'classname' => \App\Entity\EvcCategory::class]],
			['data_class' => \App\Entity\EvcCategory::class]
		);
		
		return $this->render('category/page.html.twig', [
			'category' => $category,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{slug}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $slug, EntityManagerInterface $entityManager, EvcCategoryRepository $categRepo): Response
	{
		
		$category = $categRepo->getCategoryBySlug($slug);

		$form = $this->createForm(ProductType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_page', ['id' => $slug]);
        }
	}
}
