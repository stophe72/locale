<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 * @ORM\Table(name="groupe")
 * @UniqueEntity("libelle")
 */
class GroupeEntity extends BaseEntity
{
    /**
     * @var UserEntity
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\UserEntity")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */

    private $user;
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le libellé doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le libellé doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $libelle;

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

    /**
     * Get )
     *
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set )
     *
     * @param  string  $libelle  )
     *
     * @return  self
     */
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }
}