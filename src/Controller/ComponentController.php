<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcComponentRepository;
use App\Form\Type\FormType;
use App\Service\FormService;

#[Route('/component', name: 'app_component_')]
class ComponentController extends AbstractController
{
    public function __construct(
        
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(Request $request, PaginatorInterface $paginator, EvcComponentRepository $compRepo): Response
    {
		$components = $compRepo->getAllComponents();
		$pagination = $paginator->paginate(
			$components, 
			$request->query->getInt('page', 1),
			10
		);

		return $this->render('component/list.html.twig', [
			'pagination' => $pagination
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id, EvcComponentRepository $compRepo): Response
    {
		$component = $compRepo->getComponent($id);
		
		$form = $this->createForm(
			FormType::class, 
			$component, 
			['attr' => ['id' => $id, 'url' => '/component', 'classname' => \App\Entity\EvcComponent::class]],
			['data_class' => \App\Entity\EvcComponent::class]
		);

		return $this->render('component/page.html.twig', [
			'component' => $component,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id, EvcComponentRepository $compRepo, FormService $formService): Response
	{
		$component = $compRepo->getComponent($id);
		$formService->save($request,$component);
        return $this->redirectToRoute('app_component_page', ['id' => $id]);
	}
}
