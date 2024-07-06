<?php

namespace App\Controller;

use App\Entity\EvcProduct;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EvcProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        protected EvcProductRepository $prodRepo,
		protected PaginatorInterface $paginator
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

	#[Route('/prod/{id}', name: 'page')]
    public function get($id): Response
    {
		$products = $this->prodRepo->getProduct($id);
		return $this->render('prod/list.html.twig', [
			'products' => $products
        ]);
    }
    
}
