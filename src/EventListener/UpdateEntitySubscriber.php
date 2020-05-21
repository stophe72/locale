<?php

namespace App\EventListener;

use App\Entity\BaseEntity;
use App\Entity\BaseGroupeEntity;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class UpdateEntitySubscriber implements EventSubscriber
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof BaseEntity) {
            $date = new DateTime();
            $entity->setDateCreation($date);
            $entity->setDateModification($date);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof BaseEntity) {
            $entity->setDateModification(new DateTime());
        }
    }
}
