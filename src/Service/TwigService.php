<?php

namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Repository\EvcComponentsRepository;

class TwigService extends AbstractExtension implements GlobalsInterface
{
    private $components;

    public function __construct(EvcComponentsRepository $compRepo)
    {
        // Fetch the components from the repository
        $this->components = $compRepo->getComponents();
    }

    public function getGlobals(): array
    {
        // Return an array of global variables
        return [
            'components' => $this->components,
        ];
    }
}

