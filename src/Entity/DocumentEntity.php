<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @ORM\Table(name="document")
 */
class DocumentEntity extends BaseGroupeLibelleEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=MajeurEntity::class)
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fichier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observations;


    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(?MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }
}
