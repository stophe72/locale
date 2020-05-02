<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PatrimoineEntity", mappedBy="typeOperation")
     */
    private $patrimoineEntities;

    public function __construct()
    {
        $this->patrimoineEntities = new ArrayCollection();
    }


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

    /**
     * @return Collection|PatrimoineEntity[]
     */
    public function getPatrimoineEntities(): Collection
    {
        return $this->patrimoineEntities;
    }

    public function addPatrimoineEntity(PatrimoineEntity $patrimoineEntity): self
    {
        if (!$this->patrimoineEntities->contains($patrimoineEntity)) {
            $this->patrimoineEntities[] = $patrimoineEntity;
            $patrimoineEntity->setTypeOperation($this);
        }

        return $this;
    }

    public function removePatrimoineEntity(PatrimoineEntity $patrimoineEntity): self
    {
        if ($this->patrimoineEntities->contains($patrimoineEntity)) {
            $this->patrimoineEntities->removeElement($patrimoineEntity);
            // set the owning side to null (unless already changed)
            if ($patrimoineEntity->getTypeOperation() === $this) {
                $patrimoineEntity->setTypeOperation(null);
            }
        }

        return $this;
    }
}
