<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisiteRepository")
 * @ORM\Table(name="visite")
 * @UniqueEntity(fields={"majeur", "date"})
 */
class VisiteEntity extends BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @Assert\PositiveOrZero
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $presence;


    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(?MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of presence
     *
     * @return  int
     */
    public function getPresence()
    {
        return $this->presence;
    }

    /**
     * Set the value of presence
     *
     * @param  int  $presence
     *
     * @return  self
     */
    public function setPresence(int $presence)
    {
        $this->presence = $presence;

        return $this;
    }
}
