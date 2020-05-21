<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatrimoineRepository")
 * @ORM\Table(name="patrimoine")
 */
class PatrimoineEntity extends BaseGroupeLibelleEntity
{
    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOperationEntity", inversedBy="patrimoineEntities")
     * @ORM\JoinColumn(name="typeOperationId", referencedColumnName="id", nullable=false)
     */
    private $typeOperation;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nature;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
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

    public function getTypeOperation(): ?TypeOperationEntity
    {
        return $this->typeOperation;
    }

    public function setTypeOperation(?TypeOperationEntity $typeOperation): self
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    public function getNature(): ?int
    {
        return $this->nature;
    }

    public function setNature(int $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
