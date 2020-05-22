<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteGestionRepository")
 * @ORM\Table(name="compteGestion")
 */
class CompteGestionEntity extends BaseEntity
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOperationEntity")
     * @ORM\JoinColumn(name="typeOperationId", referencedColumnName="id", nullable=false)
     */
    private $typeOperation;

    /**
     * @Assert\Positive
     *
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $montant;

    /**
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(type="smallint")
     */
    private $nature;

    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DonneeBancaireEntity", inversedBy="compteGestionEntities")
     * @ORM\JoinColumn(name="donneeBancaireId", referencedColumnName="id", nullable=false)
     */
    private $donneeBancaire;

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

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

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

    public function getDonneeBancaire(): ?DonneeBancaireEntity
    {
        return $this->donneeBancaire;
    }

    public function setDonneeBancaire(?DonneeBancaireEntity $donneeBancaire): self
    {
        $this->donneeBancaire = $donneeBancaire;

        return $this;
    }

    /**
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param  string  $libelle
     *
     * @return  self
     */
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
