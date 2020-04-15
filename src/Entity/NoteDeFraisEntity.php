<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteDeFraisRepository")
 * @ORM\Table("noteDeFrais")
 */
class NoteDeFraisEntity extends BaseUserEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\TypeFraisEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="typeFraisId", referencedColumnName="id", nullable=false)
     */
    private $typeFrais;

    /**
     * @Assert\Positive
     *
     * @ORM\Column(type="float")
     */
    private $montant;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeFrais(): ?TypeFraisEntity
    {
        return $this->typeFrais;
    }

    public function setTypeFrais(TypeFraisEntity $typeFrais): self
    {
        $this->typeFrais = $typeFrais;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
