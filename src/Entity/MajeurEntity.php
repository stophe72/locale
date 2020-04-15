<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MajeurRepository")
 * @ORM\Table(name="majeur")
 */
class MajeurEntity extends BaseUserEntity
{
    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=25, nullable=false)
     */
    private $civilite;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @ORM\Column(name="nomEtatCivil", type="string", length=100)
     */
    private $nomEtatCivil;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $prenom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AdresseEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id", nullable=false)
     */
    private $adresse;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=100, nullable=false)
     */
    private $lieuNaissance;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="numeroSS", type="string", length=100, nullable=false)
     */
    private $numeroSS;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="numeroRG", type="string", length=100, nullable=false)
     */
    private $numeroRG;

    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TribunalEntity")
     * @ORM\JoinColumn(name="tribunalId", referencedColumnName="id", nullable=false)
     */
    private $tribunal;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ParametreMissionEntity")
     * @ORM\JoinColumn(name="parametreMissionId", referencedColumnName="id", nullable=false)
     */
    private $parametreMission;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="dateJugement", type="date", nullable=false)
     */
    private $dateJugement;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="debutMesure", type="date", nullable=false)
     */
    private $debutMesure;

    /**
     * @Assert\NotNull
     *
     * @ORM\Column(name="finMesure", type="date", nullable=false)
     */
    private $finMesure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompteGestionEntity", mappedBy="majeur")
     */
    private $compteGestionEntities;

    public function __construct()
    {
        $this->compteGestionEntities = new ArrayCollection();
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = ucfirst($prenom);

        return $this;
    }

    public function getAdresse(): ?AdresseEntity
    {
        return $this->adresse;
    }

    public function setAdresse(AdresseEntity $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNumeroSS(): ?string
    {
        return $this->numeroSS;
    }

    public function setNumeroSS(string $numeroSS): self
    {
        $this->numeroSS = strtoupper($numeroSS);

        return $this;
    }

    public function getTribunal(): ?TribunalEntity
    {
        return $this->tribunal;
    }

    public function setTribunal(?TribunalEntity $tribunal): self
    {
        $this->tribunal = $tribunal;

        return $this;
    }

    public function getDateJugement(): ?\DateTimeInterface
    {
        return $this->dateJugement;
    }

    public function setDateJugement(\DateTimeInterface $dateJugement): self
    {
        $this->dateJugement = $dateJugement;

        return $this;
    }

    public function getDebutMesure(): ?\DateTimeInterface
    {
        return $this->debutMesure;
    }

    public function setDebutMesure(\DateTimeInterface $debutMesure): self
    {
        $this->debutMesure = $debutMesure;

        return $this;
    }

    public function getFinMesure(): ?\DateTimeInterface
    {
        return $this->finMesure;
    }

    public function setFinMesure(\DateTimeInterface $finMesure): self
    {
        $this->finMesure = $finMesure;

        return $this;
    }

    /**
     * Get the value of numeroRG
     */
    public function getNumeroRG(): ?string
    {
        return $this->numeroRG;
    }

    /**
     * Set the value of numeroRG
     *
     * @return  self
     */
    public function setNumeroRG(?string $numeroRG)
    {
        $this->numeroRG = strtoupper($numeroRG);

        return $this;
    }

    /**
     * Get the value of nomEtatCivil
     */
    public function getNomEtatCivil(): ?string
    {
        return $this->nomEtatCivil;
    }

    /**
     * Set the value of nomEtatCivil
     *
     * @return  self
     */
    public function setNomEtatCivil(?string $nomEtatCivil)
    {
        $this->nomEtatCivil = $nomEtatCivil;

        return $this;
    }

    /**
     * Get the value of parametreMission
     */
    public function getParametreMission(): ?ParametreMissionEntity
    {
        return $this->parametreMission;
    }

    /**
     * Set the value of parametreMission
     *
     * @return  self
     */
    public function setParametreMission(ParametreMissionEntity $parametreMission)
    {
        $this->parametreMission = $parametreMission;

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
            $compteGestionEntity->setMajeur($this);
        }

        return $this;
    }

    public function removeCompteGestionEntity(CompteGestionEntity $compteGestionEntity): self
    {
        if ($this->compteGestionEntities->contains($compteGestionEntity)) {
            $this->compteGestionEntities->removeElement($compteGestionEntity);
            // set the owning side to null (unless already changed)
            if ($compteGestionEntity->getMajeur() === $this) {
                $compteGestionEntity->setMajeur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom . " " . $this->prenom;
    }

    /**
     * Get the value of lieuNaissance
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set the value of lieuNaissance
     *
     * @return  self
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }
}
