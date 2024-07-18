<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EvcLangRepository;
use App\Form\Type\FormType;
use App\Service\FormService;

#[Route('/lang', name: 'app_lang_')]
class LangController extends AbstractController
{
    public function __construct(
        protected EvcLangRepository $langRepo
    ) {
		
    }
	
	#[Route('', name: 'list')]
    public function list(): Response
    {
		$langs = $this->langRepo->getAllLangs();

		return $this->render('lang/list.html.twig', [
			'langs' => $langs
        ]);
    }

	#[Route('/{id}', name: 'page')]
    public function get($id): Response
    {
		$lang = $this->langRepo->getLang($id);
		
		$form = $this->createForm(
			FormType::class, 
			$lang, 
			['attr' => ['id' => $id, 'url' => '/lang', 'classname' => \App\Entity\EvcLang::class]],
			['data_class' => \App\Entity\EvcLang::class]
		);

		return $this->render('lang/page.html.twig', [
			'lang' => $lang,
			'form' => $form->createView(),
        ]);
    }

	#[Route('/set/{id}', name: 'set', methods: ['POST'])]
	public function save(Request $request, $id, FormService $formService): Response
	{
		$lang = $this->langRepo->getLang($id);
		$formService->save($request,$lang);
        return $this->redirectToRoute('app_lang_page', ['id' => $id]);
	}
}

