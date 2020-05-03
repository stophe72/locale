<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteDeFraisRepository")
 * @ORM\Table("noteDeFrais")
 */
class NoteDeFraisEntity extends BaseLibelleEntity
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

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FicheFraisEntity", inversedBy="noteDeFraisEntities")
     * @ORM\JoinColumn(name="ficheFraisId", referencedColumnName="id", nullable=false)
     */
    private $ficheFrais;


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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getFicheFrais(): ?FicheFraisEntity
    {
        return $this->ficheFrais;
    }

    public function setFicheFrais(?FicheFraisEntity $ficheFrais): self
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }
}
