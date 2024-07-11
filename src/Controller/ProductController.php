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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EvcProduct;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(Request $request, PaginatorInterface $paginator, EvcProductRepository $prodRepo): Response
    {
		$products = $prodRepo->getProducts();
		$pagination = $paginator->paginate(
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
    public function get($id, EvcProduct $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);

		return $this->render('prod/page.html.twig', [
			'product' => $product,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id, EntityManagerInterface $entityManager, EvcProduct $product): Response
	{
		$form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_prod_page', ['id' => $id]);
        }
	}
    
}
