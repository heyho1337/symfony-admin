<?php
namespace App\EventListener;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\EvcLangRepository;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(protected EvcLangRepository $langRepo, protected RequestStack $requestStack)
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdate',
            BeforeEntityPersistedEvent::class => 'onBeforeEntityPersist',
            BeforeCrudActionEvent::class => 'onBeforeCrudAction',
        ];
    }

    public function onBeforeEntityUpdate(BeforeEntityUpdatedEvent $event)
    {
        $this->addLangsToRequest();
    }

    public function onBeforeEntityPersist(BeforeEntityPersistedEvent $event)
    {
        $this->addLangsToRequest();
    }

    public function onBeforeCrudAction(BeforeCrudActionEvent $event)
    {
        $crudAction = $this->requestStack->getCurrentRequest()->query->get('crudAction');
        if ($crudAction === 'edit' || $crudAction === 'new') {
            $this->addLangsToRequest();
        }
    }

    private function addLangsToRequest()
    {
        $langs = $this->langRepo->getActiveLangs();
        $this->requestStack->getCurrentRequest()->attributes->set('langs', $langs);
    }
}
