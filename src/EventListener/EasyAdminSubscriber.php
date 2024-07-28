<?php
namespace App\EventListener;

use App\DTO\EvcProductExtended;
use App\Entity\EvcProduct;
use App\Service\FieldService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\EvcLangRepository;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    protected FieldService $fieldService;
    protected $langs;
    public function __construct(
        protected EvcLangRepository $langRepo,
        protected RequestStack $requestStack,
        protected EntityManagerInterface $entityManager)
    {
        $this->fieldService = new FieldService($this->requestStack,$this->entityManager);
        $this->fieldService->getEntityData(EvcProduct::class);
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdate',
            BeforeEntityPersistedEvent::class => 'onBeforeEntityPersist',
            BeforeCrudActionEvent::class => 'onBeforeCrudAction',
            AfterEntityUpdatedEvent::class => 'onAfterEntityUpdate',
            AfterEntityPersistedEvent::class => 'onAfterEntityPersist',
        ];
    }

    public function onBeforeEntityUpdate(BeforeEntityUpdatedEvent $event)
    {
        $formData = $this->fieldService->request->request->all()['EvcProduct'];
        foreach ($formData as $key => $value) {
            if (str_contains($key, 'translationData_')) {
                $fieldNameArray = explode("_", $key);
                $getFieldName = "get".ucfirst($fieldNameArray[2]).ucfirst($fieldNameArray[3]);
                $setFieldNameByLang = "set".ucfirst($fieldNameArray[2]).ucfirst($fieldNameArray[3]."ByLang");
                $this->fieldService->entityInstance->$setFieldNameByLang($value,$fieldNameArray[1]);
            }
        }
        //dd($this->fieldService->entityInstance);
        $this->addLangsToRequest();
    }

    public function onBeforeEntityPersist(BeforeEntityPersistedEvent $event)
    {

        $this->addLangsToRequest();
    }

    public function onAftereEntityPersist(AfterEntityPersistedEvent $event)
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $session->getFlashBag()->add('notice', 'Added!');
    }

    public function onAfterEntityUpdate(AfterEntityUpdatedEvent $event)
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $session->getFlashBag()->add('notice', 'Updated!');
    }

    public function onBeforeCrudAction(BeforeCrudActionEvent $event)
    {
        $crudAction = $this->requestStack->getCurrentRequest()->query->get('crudAction');
        if ($crudAction === 'edit' || $crudAction === 'new') {
            $this->addLangsToRequest();
            $fields = $this->fieldService->entityMetadata->fieldMappings;
            $translationData = new \stdClass();
            foreach ($fields as $field) {
                if($field['type'] === 'json') {
                    $fieldNameArray = explode("_", $field['fieldName']);
                    $fieldName = "get" . ucfirst($fieldNameArray[0]) . ucfirst($fieldNameArray[1]);
                    $fieldValue = $this->fieldService->entityInstance->$fieldName();
                    foreach($fieldValue as $key => $value){
                        $translationData->{"{$key}_{$field['fieldName']}"} = $value;
                    }
                }
            }
            $this->fieldService->entityInstance->setTranslationData($translationData);
        }
    }

    private function addLangsToRequest()
    {
        $this->langs = $this->langRepo->getActiveLangs();
        $this->requestStack->getCurrentRequest()->attributes->set('langs', $this->langs);
    }
}
