<?php

namespace App\Controller;

use App\Entity\EvcProduct;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/prod', name: 'app_prod_')]
class ProductController extends AbstractController
{
    
	public function __construct(
        /*protected LoggerInterface $logger,,*/
    ) {
    }
	
	#[Route('', name: 'list')]
    public function list(): Response
    {
       
    }
    
}
