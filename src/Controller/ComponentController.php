<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcComponentRepository;
use App\Service\FormService;
use App\Form\Type\ComponentType;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/component', name: 'app_component_')]
class ComponentController extends AbstractController
{
    public function __construct(
        protected EvcComponentRepository $compRepo,
		protected PaginatorInterface $paginator,
		protected FormService $formService,
		protected EntityManagerInterface $entityManager
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(Request $request): Response
    {
		$components = $this->compRepo->getAllComponents();
		$pagination = $this->paginator->paginate(
			$components, 
			$request->query->getInt('page', 1),
			10
		);

		//add the $products to the pagination;
		return $this->render('component/list.html.twig', [
			'pagination' => $pagination
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id): Response
    {
		
		$component = $this->compRepo->getComponent($id);
        $form = $this->createForm(ComponentType::class, $component);

		return $this->render('component/page.html.twig', [
			'component' => $component,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id): Response
	{
		$component = $this->compRepo->getComponent($id);
		$form = $this->createForm(ComponentType::class, $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($component);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_component_page', ['id' => $id]);
        }
	}
}
