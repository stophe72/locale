<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonneeBancaireRepository")
 * @ORM\Table(name="donneeBancaire")
 * @UniqueEntity(fields={"majeur", "agenceBancaire", "numeroCompte"})
 */
class DonneeBancaireEntity extends BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity", inversedBy="donneeBancaireEntities")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AgenceBancaireEntity")
     * @ORM\JoinColumn(name="agenceBancaireId", referencedColumnName="id", nullable=false)
     */
    private $agenceBancaire;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\TypeCompteEntity")
     * @ORM\JoinColumn(name="typeCompteId", referencedColumnName="id", nullable=false)
     */
    private $typeCompte;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="numeroCompte", type="string", length=100)
     */
    private $numeroCompte;

    /**
     * @ORM\Column(name="soldeCourant", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $soldeCourant;

    /**
     * @ORM\Column(name="soldePrecedent", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $soldePrecedent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompteGestionEntity", mappedBy="donneeBancaire")
     * @ORM\JoinColumn(name="compteGestionId", referencedColumnName="id", nullable=false)
     */
    private $compteGestionEntities;

    public function __construct()
    {
        $this->compteGestionEntities = new ArrayCollection();
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
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSoldeCourant(): ?string
    {
        return $this->soldeCourant;
    }

    public function setSoldeCourant(?string $soldeCourant): self
    {
        $this->soldeCourant = $soldeCourant;

        return $this;
    }

    public function getSoldePrecedent(): ?string
    {
        return $this->soldePrecedent;
    }

    public function setSoldePrecedent(?string $soldePrecedent): self
    {
        $this->soldePrecedent = $soldePrecedent;

        return $this;
    }

    /**
     * @return Collection|CompteGestionEntity[]
     */
    public function getCompteGestionEntities(): Collection
    {
        return $this->compteGestionEntities;
    }

    public function addCompteGestionEntity(CompteGestionEntity $compteGestionEntity): self
    {
        if (!$this->compteGestionEntities->contains($compteGestionEntity)) {
            $this->compteGestionEntities[] = $compteGestionEntity;
            $compteGestionEntity->setDonneeBancaire($this);
        }

        return $this;
    }

    public function removeCompteGestionEntity(CompteGestionEntity $compteGestionEntity): self
    {
        if ($this->compteGestionEntities->contains($compteGestionEntity)) {
            $this->compteGestionEntities->removeElement($compteGestionEntity);
            // set the owning side to null (unless already changed)
            if ($compteGestionEntity->getDonneeBancaire() === $this) {
                $compteGestionEntity->setDonneeBancaire(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumeroCompte();
    }
}
