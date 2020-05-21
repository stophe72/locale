<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteDeFraisRepository")
 * @ORM\Table("noteDeFrais")
 */
class NoteDeFraisEntity extends BaseEntity
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le libellé doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le libellé doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $libelle;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\TypeFraisEntity")
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
        $this->lieu = strtoupper($lieu);

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

    /**
     * Get )
     *
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set )
     *
     * @param  string  $libelle  )
     *
     * @return  self
     */
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
