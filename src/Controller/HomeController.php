<?php

namespace App\Controller;

use App\Repository\EvcComponentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    
	public function __construct(
        protected EvcComponentsRepository $compRepo
    ) {
		
    }
	
	#[Route('/', name: 'app_home')]
    public function index(): Response
    {
		return $this->render('app/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
