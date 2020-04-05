<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisiteRepository")
 * @ORM\Table(name="visite")
 */
class VisiteEntity extends BaseUserEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;

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
}
