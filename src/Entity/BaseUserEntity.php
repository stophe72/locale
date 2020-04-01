<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class BaseUserEntity extends BaseEntity
{
    /**
     * @var UserEntity
     * @ORM\ManyToOne(targetEntity="App\Entity\UserEntity")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * Get the value of user
     *
     * @return  UserEntity
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param  UserEntity  $user
     *
     * @return  self
     */
    public function setUser(UserEntity $user)
    {
        $this->user = $user;

        return $this;
    }

    public function isOwnBy(UserEntity $user)
    {
        return $this->getUser()->getId() == $user->getId();
    }
}
