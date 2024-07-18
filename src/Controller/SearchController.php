<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Type\SearchFormType;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends AbstractController
{
	#[Route('/search', name: 'search_component')]
	public function search(string $nameValue, string $sort, string $direction, callable $extraInput = null): Response
    {
		$form = $this->createForm(SearchFormType::class, options:['name_value' => $nameValue, 'extraInput' => $extraInput]);
		
		return $this->render('search/search_component.html.twig', [
            'form' => $form,
			'sort' => $sort,
			'direction' => $direction,
			'name' => $nameValue
        ]);
    }
}
