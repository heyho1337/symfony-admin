<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use App\Controller\LoginController;

class AuthListener
{
    public function __construct(protected AuthorizationCheckerInterface $authorizationChecker)
    {

    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $controllerObject = $controller[0];
        if ($controllerObject instanceof LoginController || $controllerObject instanceof ProfilerController ) {
            return;
        }
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

    }
}
