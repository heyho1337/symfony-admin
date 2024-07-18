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
        protected EvcComponentRepository $compRepo
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(): Response
    {
		$components = $this->compRepo->getAllComponents();

		return $this->render('component/list.html.twig', [
			'components' => $components
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id): Response
    {
		$component = $this->compRepo->getComponent($id);
		
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
	public function save(Request $request, $id, FormService $formService): Response
	{
		$component = $this->compRepo->getComponent($id);
		$formService->save($request,$component);
        return $this->redirectToRoute('app_component_page', ['id' => $id]);
	}
}
