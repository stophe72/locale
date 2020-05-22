<?php

namespace App\EntityListener;

use App\Entity\MajeurEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class MajeurEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(MajeurEntity $majeur, LifecycleEventArgs $event)
    {
        $majeur->computeSlug($this->slugger);
    }

    public function preUpdate(MajeurEntity $majeur, LifecycleEventArgs $event)
    {
        $majeur->computeSlug($this->slugger);
    }
}
