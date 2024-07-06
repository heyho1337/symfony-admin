<?php

namespace App\Controller;

use App\Repository\EvcComponentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    
	public function __construct(
        protected EvcComponentsRepository $compRepo
    ) {
    }
	
	#[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
		$components = $this->compRepo->getComponents();
		return $this->render('app/index.html.twig', [
            'controller_name' => 'HomeController',
			'components' => $components
        ]);
    }
}
