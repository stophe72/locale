<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeOperationRepository")
 * @ORM\Table(name="typeOperation")
 * @UniqueEntity("libelle")
 */
class TypeOperationEntity extends BaseLibelleEntity
{
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $checkable;

    /**
     * @ORM\Column(name="libelleRapport", type="string", length=100, nullable=true)
     */
    private $libelleRapport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FamilleTypeOperationEntity", inversedBy="typeOperationEntities")
     * @ORM\JoinColumn(name="familleTypeOperationId", referencedColumnName="id", nullable=false)
     */
    private $familleTypeOperation;


    public function getCheckable(): ?bool
    {
        return $this->checkable;
    }

    public function setCheckable(bool $checkable): self
    {
        $this->checkable = $checkable;

        return $this;
    }

    public function getLibelleRapport(): ?string
    {
        return $this->libelleRapport;
    }

    public function setLibelleRapport(?string $libelleRapport): self
    {
        $this->libelleRapport = $libelleRapport;

        return $this;
    }

    public function getFamilleTypeOperation(): ?FamilleTypeOperationEntity
    {
        return $this->familleTypeOperation;
    }

    public function setFamilleTypeOperation(?FamilleTypeOperationEntity $familleTypeOperation): self
    {
        $this->familleTypeOperation = $familleTypeOperation;

        return $this;
    }
}
