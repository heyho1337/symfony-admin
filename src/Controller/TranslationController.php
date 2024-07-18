<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EvcProductTranslationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/translation', name: 'app_translation_')]
class TranslationController extends AbstractController
{
    #[Route('/set/{type}/{slug}', name: 'set', methods: ['POST'])]
    public function set(
		string $type,
		string $slug, 
		Request $request, 
		EvcProductTranslationRepository $transRepo, 
		EntityManagerInterface $entityManager, 
		ValidatorInterface $validator): Response
    {
		$data = $request->request->all();
		foreach($data as $key => $value){
			if(\gettype($key) == 'integer'){
				$translation = $transRepo->find($key);
				$translation->setTransText($value);

				$errors = $validator->validate($translation);

				if (count($errors) > 0) {
					foreach ($errors as $error) {
						$label = $error->getRoot()->getTransLabel();
						$lang = $error->getRoot()->getTransLang();
						$msg = $error->getMessage();
						$flash = "{$lang} {$label}: {$msg}";
						$this->addFlash('error', $flash);
					}

					return $this->redirectToRoute("app_{$type}_page", ['slug' => $slug]);
				}
				$entityManager->persist($translation);
            	$entityManager->flush();
			}
		}

		$this->addFlash('notice','Saved successfully');
		return $this->redirectToRoute('app_prod_page', ['slug' => $slug]);
    }
}
