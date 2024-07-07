<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcProductRepository;
use App\Service\FormService;
use App\Form\Type\ProductType;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        protected EvcProductRepository $prodRepo,
		protected PaginatorInterface $paginator,
		protected FormService $formService
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(Request $request): Response
    {
		$products = $this->prodRepo->getProducts();
		$pagination = $this->paginator->paginate(
			$products, /* query NOT result */
			$request->query->getInt('page', 1), /*page number*/
			10 /*limit per page*/
		);

		//add the $products to the pagination;
		return $this->render('prod/list.html.twig', [
			'pagination' => $pagination
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id): Response
    {
		
		$product = $this->prodRepo->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $form = $this->createForm(ProductType::class, $product);
		
		//$productData = $this->prodRepo->getProduct($id);
		//$form = $this->formService->gen($productData);
		//var_dump($form);
		return $this->render('prod/page.html.twig', [
			'product' => $product,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id): Response
	{
		$product = $this->prodRepo->find($id);
		if (!$product) {
			throw $this->createNotFoundException('Product not found');
		}

		// Update product with form data
		// Add your logic here to handle the form data and update the product entity
		// For example:
		// $product->setProdName($request->request->get('prod_name'));

		//$this->prodRepo->save($product); // Ensure your repository has a save method to persist the entity

		return $this->redirectToRoute('app_prod_page', ['id' => $id]);
	}
    
}
