<?php

// src/Service/FormService.php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormService extends AbstractController
{
    
	public array $form = [];
	
	public function __construct()
    {
    }

	public function text(string $value, string $name, array $el): string
    {
		return $this->renderView('form/text.html.twig', [
			'value' => $value,
			'name' => $name,
			'el' => $el
        ]);
    }

	public function hidden(string $value, string $name, array $el)
    {
		
    }

	public function active(string $value, string $name, array $el)
    {
		
    }

	public function datetime(\DateTime $value, string $name, array $el)
    {
		
    }

	public function price(string $value, string $name, array $el)
    {
		
    }

	public function gen($data): array
    {
        $product = $data['product'];
        $reflection = new \ReflectionClass($product);
        foreach ($data['formTypes'] as $field => $metaData) {
            $getter = 'get' . str_replace('_', '', ucwords($field, '_'));
            if ($reflection->hasMethod($getter)) {
                $value = $product->{$getter}();
                $formRow = $this->{$metaData['formType']}($value, $field, $metaData);
                array_push($this->form, $formRow);
            }
        }

        return $this->form;
    }
}
