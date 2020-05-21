<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleTypeOperationRepository")
 * @ORM\Table(name="familleTypeOperation")
 * @UniqueEntity("libelle")
 */
class FamilleTypeOperationEntity extends BaseGroupeLibelleEntity
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypeOperationEntity", mappedBy="familleTypeOperation")
     */
    private $typeOperationEntities;

    /**
     * @ORM\Column(name="libelleRapport", type="string", length=100, nullable=true)
     */
    private $libelleRapport;

    /**
     * @Assert\Positive
     *
     * @ORM\Column(name="ordreAffichage", type="integer", nullable=false)
     */
    private $ordreAffichage;

    public function __construct()
    {
        $this->typeOperationEntities = new ArrayCollection();
    }

    /**
     * @return Collection|TypeOperationEntity[]
     */
    public function getTypeOperationEntities(): Collection
    {
        return $this->typeOperationEntities;
    }

    public function addTypeOperationEntity(TypeOperationEntity $typeOperationEntity): self
    {
        if (!$this->typeOperationEntities->contains($typeOperationEntity)) {
            $this->typeOperationEntities[] = $typeOperationEntity;
            $typeOperationEntity->setFamilleTypeOperation($this);
        }

        return $this;
    }

    public function removeTypeOperationEntity(TypeOperationEntity $typeOperationEntity): self
    {
        if ($this->typeOperationEntities->contains($typeOperationEntity)) {
            $this->typeOperationEntities->removeElement($typeOperationEntity);
            // set the owning side to null (unless already changed)
            if ($typeOperationEntity->getFamilleTypeOperation() === $this) {
                $typeOperationEntity->setFamilleTypeOperation(null);
            }
        }

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

    public function getOrdreAffichage(): ?int
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(int $ordreAffichage): self
    {
        $this->ordreAffichage = $ordreAffichage;

        return $this;
    }
}
