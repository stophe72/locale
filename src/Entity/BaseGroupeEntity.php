<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseGroupeEntity extends BaseEntity
{
    /**
     * @var GroupeEntity
     *
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupeEntity")
     * @ORM\JoinColumn(name="groupeId", referencedColumnName="id", nullable=false)
     */
    private $groupe;


    public function isOwnBy(UserEntity $user)
    {
        return $this->getGroupe()->getId() == $user->getId();
    }

    /**
     * Get the value of groupe
     *
     * @return  GroupeEntity
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set the value of groupe
     *
     * @param  GroupeEntity  $groupe
     *
     * @return  self
     */
    public function setGroupe(GroupeEntity $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }
}
