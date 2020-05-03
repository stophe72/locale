<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheFraisRepository")
 * @ORM\Table(name="ficheFrais")
 */
class FicheFraisEntity extends BaseUserEntity
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteDeFraisEntity", mappedBy="ficheFrais", fetch="EAGER")
     */
    private $noteDeFraisEntities;

    public function __construct()
    {
        $this->noteDeFraisEntities = new ArrayCollection();
    }

    /**
     * @return Collection|NoteDeFraisEntity[]
     */
    public function getNoteDeFraisEntities(): Collection
    {
        return $this->noteDeFraisEntities;
    }

    public function addNoteDeFraisEntity(NoteDeFraisEntity $noteDeFraisEntity): self
    {
        if (!$this->noteDeFraisEntities->contains($noteDeFraisEntity)) {
            $this->noteDeFraisEntities[] = $noteDeFraisEntity;
            $noteDeFraisEntity->setFicheFrais($this);
        }

        return $this;
    }

    public function removeNoteDeFraisEntity(NoteDeFraisEntity $noteDeFraisEntity): self
    {
        if ($this->noteDeFraisEntities->contains($noteDeFraisEntity)) {
            $this->noteDeFraisEntities->removeElement($noteDeFraisEntity);
            // set the owning side to null (unless already changed)
            if ($noteDeFraisEntity->getFicheFrais() === $this) {
                $noteDeFraisEntity->setFicheFrais(null);
            }
        }

        return $this;
    }
}
