<?php

namespace App\EventListener;

use App\Entity\BaseEntity;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class UpdateEntitySubscriber implements EventSubscriber
{
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
