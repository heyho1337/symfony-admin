<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcComponentRepository;
use App\Form\Type\FormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

		//add the $products to the pagination;
		return $this->render('component/list.html.twig', [
			'pagination' => $pagination
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id, EvcComponentRepository $compRepo, SessionInterface $session): Response
    {
		$component = $compRepo->getComponent($id);
		
        $flashMessages = $session->getFlashBag()->all();
		
		$form = $this->createForm(
			FormType::class, 
			$component, 
			['attr' => ['id' => $id, 'url' => '/component', 'classname' => \App\Entity\EvcComponent::class]],
			['data_class' => \App\Entity\EvcComponent::class]
		);

		return $this->render('component/page.html.twig', [
			'component' => $component,
			'form' => $form->createView(),
			'msg' => $flashMessages
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id, EvcComponentRepository $compRepo, EntityManagerInterface $entityManager): Response
	{
		$component = $compRepo->getComponent($id);
		
		$form = $this->createForm(ComponentType::class, $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($component);
            $entityManager->flush();

			$this->addFlash('notice','Saved successfully');

            return $this->redirectToRoute('app_component_page', ['id' => $id]);
        }
	}
}
