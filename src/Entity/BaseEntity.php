<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @Assert\NotNull
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=false)
     */
    private $dateModification;

    /**
     * @var DateTime
     *
     *  @Assert\NotNull
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @return DateTime
     */
    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    /**
     * @param DateTime $dateCreation
     */
    public function setDateCreation(?DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return DateTime
     */
    public function getDateModification(): ?DateTime
    {
        return $this->dateModification;
    }

    /**
     * @param DateTime $dateModification
     */
    public function setDateModification(?DateTime $dateModification)
    {
        $this->dateModification = $dateModification;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
