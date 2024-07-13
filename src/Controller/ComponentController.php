<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcComponentRepository;
use App\Form\Type\ComponentType;
use App\Entity\EvcComponent;
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
		$form = $this->createForm(ComponentType::class, $component, ['attr' => ['id' => $id]]);

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

	#[Route('/sort/{id}/{position}', name: 'sort', methods: ['POST'])]
	public function sortAction($id, $position, EvcComponentRepository $compRepo, EntityManagerInterface $entityManager)
	{
		$component = $compRepo->getComponent($id);

		$component->setPosition($position);
		$entityManager->persist($component);
		$entityManager->flush();
		return new JsonResponse(['success' => true, 'result' => $component->getPosition()]);
	}

	#[Route('/{id}/onoff', name: 'onoff', methods: ['POST'])]
    public function onoff($id, EvcComponentRepository $compRepo, EntityManagerInterface $entityManager): JsonResponse
    {
        $component = $compRepo->getComponent($id);

		$activeStatus = $component->getCompActive();
		if($activeStatus == 1){ 
        	$component->setCompActive(0);
		}
		else{
			$component->setCompActive(1);
		}
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'result' => $component->getCompActive()]);
    }
}
