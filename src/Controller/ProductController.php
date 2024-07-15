<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcProductRepository;
use App\Form\Type\FormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(Request $request, PaginatorInterface $paginator, EvcProductRepository $prodRepo, AuthorizationCheckerInterface $authorizationChecker): Response
    {
		if (!$authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw new AccessDeniedException();
		}
		$nameValue = $request->query->get('name', '') ?? '';
		$products = $prodRepo->getProductsWithFilters($nameValue);
		$pagination = $paginator->paginate(
			$products,
			$request->query->getInt('page', 1),
			10
		);

		return $this->render('prod/list.html.twig', [
			'pagination' => $pagination,
			'nameValue' => $nameValue
        ]);
    }

	#[Route('/{slug}', name: 'page')]
    public function get($slug, EvcProductRepository $prodRepo, EntityManagerInterface $entityManager): Response
    {
        $entityManager->getFilters()
            ->enable('ActiveCategory');
		
		$product = $prodRepo->getProductBySlug($slug);
		
		$form = $this->createForm(
			FormType::class, 
			$product, 
			['attr' => ['id' => $product->getId(), 'url' => '/product', 'classname' => \App\Entity\EvcProduct::class]],
			['data_class' => \App\Entity\EvcProduct::class]
		);
		
		$form->add('prod_category', EntityType::class, [
			'class' => EvcCategory::class,
			'choice_label' => 'categoryName',
			'label' => 'Categories',
			'disabled' => false,
			'required' => true,
			'multiple' => true,
			'expanded' => false,
			'autocomplete' => true,
		]);
		
		return $this->render('prod/page.html.twig', [
			'product' => $product,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{slug}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $slug, EntityManagerInterface $entityManager, EvcProductRepository $prodRepo): Response
	{
		
		$product = $prodRepo->getProductBySlug($slug);

		$form = $this->createForm(
			FormType::class, 
			$product, 
			['attr' => ['id' => $product->getId(), 'url' => '/product', 'classname' => \App\Entity\EvcProduct::class]],
			['data_class' => \App\Entity\EvcProduct::class]
		);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_prod_page', ['id' => $slug]);
        }
	}
    
}
