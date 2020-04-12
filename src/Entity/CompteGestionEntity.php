<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteGestionRepository")
 * @ORM\Table(name="compteGestion")
 */
class CompteGestionEntity extends BaseUserEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity", inversedBy="compteGestionEntities")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NatureOperationEntity")
     * @ORM\JoinColumn(name="natureOperationId", referencedColumnName="id", nullable=false)
     */
    private $natureOperation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOperationEntity")
     * @ORM\JoinColumn(name="typeOperationId", referencedColumnName="id", nullable=false)
     */
    private $typeOperation;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

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

    public function getNatureOperation(): ?NatureOperationEntity
    {
        return $this->natureOperation;
    }

    public function setNatureOperation(?NatureOperationEntity $natureOperation): self
    {
        $this->natureOperation = $natureOperation;

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
}
