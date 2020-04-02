<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MajeurRepository")
 * @ORM\Table(name="majeur")
 */
class MajeurEntity extends BaseUserEntity
{
    /**
     * @ORM\Column(type="string", length=6)
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AdresseEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id", nullable=false)
     */
    private $adresse;

    /**
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(name="numeroSS", type="string", length=100)
     */
    private $numeroSS;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TribunalEntity")
     * @ORM\JoinColumn(name="tribunalId", referencedColumnName="id", nullable=false)
     */
    private $tribunal;

    /**
     * @ORM\Column(name="dateJugement", type="date", nullable=false)
     */
    private $dateJugement;

    /**
     * @ORM\Column(name="debutMesure", type="date", nullable=false)
     */
    private $debutMesure;

    /**
     * @ORM\Column(name="finMesure", type="date", nullable=false)
     */
    private $finMesure;

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
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
        $this->numeroSS = $numeroSS;

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
}
