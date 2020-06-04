<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseGroupeLibelleEntity extends BaseEntity
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

    /**
     * @return  string
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param  string  $libelle
     *
     * @return  self
     */
    public function setLibelle(?string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }
}
