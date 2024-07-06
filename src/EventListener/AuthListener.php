<?php 

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Controller\BaseController;
use App\Controller\LoginController;
use App\Controller\RegController;

class AuthListener
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $controllerObject = $controller[0];

        if ($controllerObject instanceof AbstractController) {
            // Skip access check for LoginController and RegController
            if ($controllerObject instanceof LoginController || $controllerObject instanceof RegController) {
                return;
            }

            if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw new AccessDeniedException();
            }
        }
    }
}


