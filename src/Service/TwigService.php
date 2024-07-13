<?php

namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Repository\EvcComponentRepository;

class TwigService extends AbstractExtension implements GlobalsInterface
{
    private $components;

    public function __construct(EvcComponentRepository $compRepo)
    {
        // Fetch the components from the repository
        $this->components = $compRepo->getActiveComponents();
    }

    public function getGlobals(): array
    {
        // Return an array of global variables
        return [
            'components' => $this->components,
        ];
    }
}

