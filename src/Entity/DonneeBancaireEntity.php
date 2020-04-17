<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonneeBancaireRepository")
 * @ORM\Table(name="donneeBancaire")
 * @UniqueEntity(fields={"agenceBancaire", "numeroCompte"})
 */
class DonneeBancaireEntity extends BaseUserEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AgenceBancaireEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="agenceBancaireId", referencedColumnName="id", nullable=false)
     */
    private $agenceBancaire;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\TypeCompteEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="typeCompteId", referencedColumnName="id", nullable=false)
     */
    private $typeCompte;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="numeroCompte", type="string", length=100, nullable=false)
     */
    private $numeroCompte;

    /**
     * @ORM\Column(name="soldeCourant", type="float")
     */
    private $soldeCourant;

    /**
     * @ORM\Column(name="soldePrecedent", type="float")
     */
    private $soldePrecedent;


    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(?MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    public function getAgenceBancaire(): ?AgenceBancaireEntity
    {
        return $this->agenceBancaire;
    }

    public function setAgenceBancaire(AgenceBancaireEntity $agenceBancaire): self
    {
        $this->agenceBancaire = $agenceBancaire;

        return $this;
    }

    public function getTypeCompte(): ?TypeCompteEntity
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(TypeCompteEntity $typeCompte): self
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = strtoupper($numeroCompte);

        return $this;
    }

    public function getSoldeCourant(): ?float
    {
        return $this->soldeCourant;
    }

    public function setSoldeCourant(float $soldeCourant): self
    {
        $this->soldeCourant = $soldeCourant;

        return $this;
    }

    public function getSoldePrecedent(): ?float
    {
        return $this->soldePrecedent;
    }

    public function setSoldePrecedent(float $soldePrecedent): self
    {
        $this->soldePrecedent = $soldePrecedent;

        return $this;
    }
}
