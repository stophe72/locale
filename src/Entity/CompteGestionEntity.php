<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteGestionRepository")
 * @ORM\Table(name="compteGestion")
 */
class CompteGestionEntity extends BaseLibelleEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOperationEntity")
     * @ORM\JoinColumn(name="typeOperationId", referencedColumnName="id", nullable=true)
     */
    private $typeOperation;

    /**
     * @Assert\Positive
     *
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(type="integer")
     */
    private $nature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DonneeBancaireEntity", inversedBy="compteGestionEntities")
     * @ORM\JoinColumn(name="donneeBancaireId", referencedColumnName="id", nullable=false)
     */
    private $donneeBancaire;


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeOperation(): ?TypeOperationEntity
    {
        return $this->typeOperation;
    }

    public function setTypeOperation(?TypeOperationEntity $typeOperation): self
    {
        $this->typeOperation = $typeOperation;

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

    public function getNature()
    {
        return $this->nature;
    }

    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    public function getDonneeBancaire(): ?DonneeBancaireEntity
    {
        return $this->donneeBancaire;
    }

    public function setDonneeBancaire(?DonneeBancaireEntity $donneeBancaire): self
    {
        $this->donneeBancaire = $donneeBancaire;

        return $this;
    }
}
