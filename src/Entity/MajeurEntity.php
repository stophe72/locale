<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

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
     * @ORM\Column(name="nomEtatCivil", type="string", length=100, nullable=true)
     */
    private $nomEtatCivil;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $prenom;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AdresseEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id", nullable=false)
     */
    private $adresse;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\JugementEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="jugementId", referencedColumnName="id", nullable=false)
     */
    private $jugement;

    /**
     * @var ContactEntity
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ContactEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", referencedColumnName="id", nullable=true)
     */
    private $contact;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=100, nullable=false)
     */
    private $lieuNaissance;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="numeroSS", type="string", length=100, nullable=false)
     */
    private $numeroSS;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ParametreMissionEntity")
     * @ORM\JoinColumn(name="parametreMissionId", referencedColumnName="id", nullable=false)
     */
    private $parametreMission;

    /**
     * @var Date
     *
     * @ORM\Column(name="dateFinCMU", type="date", nullable=true)
     */
    private $dateFinCMU;

    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(name="nationalite", type="string", length=100, nullable=false)
     */
    private $nationalite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DonneeBancaireEntity", mappedBy="majeur")
     */
    private $donneeBancaireEntities;


    public function __construct()
    {
        $this->donneeBancaireEntities = new ArrayCollection();
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
     * @return Collection|DonneeBancaireEntity[]
     */
    public function getDonneeBancaireEntities(): Collection
    {
        return $this->donneeBancaireEntities;
    }

    public function addDonneeBancaireEntity(DonneeBancaireEntity $donneeBancaireEntity): self
    {
        if (!$this->donneeBancaireEntities->contains($donneeBancaireEntity)) {
            $this->donneeBancaireEntities[] = $donneeBancaireEntity;
            $donneeBancaireEntity->setMajeur($this);
        }

        return $this;
    }

    public function removeDonneeBancaireEntity(DonneeBancaireEntity $donneeBancaireEntity): self
    {
        if ($this->donneeBancaireEntities->contains($donneeBancaireEntity)) {
            $this->donneeBancaireEntities->removeElement($donneeBancaireEntity);
            // set the owning side to null (unless already changed)
            if ($donneeBancaireEntity->getMajeur() === $this) {
                $donneeBancaireEntity->setMajeur(null);
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

    /**
     * Get the value of dateFinCMU
     *
     * @return  Date
     */
    public function getDateFinCMU()
    {
        return $this->dateFinCMU;
    }

    /**
     * Set the value of dateFinCMU
     *
     * @param  Date  $dateFinCMU
     *
     * @return  self
     */
    public function setDateFinCMU(?DateTimeInterface $dateFinCMU)
    {
        $this->dateFinCMU = $dateFinCMU;

        return $this;
    }

    /**
     * Get the value of nationalite
     *
     * @return  string
     */
    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    /**
     * Set the value of nationalite
     *
     * @param  string  $nationalite
     *
     * @return  self
     */
    public function setNationalite(?string $nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get the value of contact
     *
     * @return  ContactEntity
     */
    public function getContact(): ?ContactEntity
    {
        return $this->contact;
    }

    /**
     * Set the value of contact
     *
     * @param  ContactEntity  $contact
     *
     * @return  self
     */
    public function setContact(?ContactEntity $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get the value of jugement
     */
    public function getJugement(): ?JugementEntity
    {
        return $this->jugement;
    }

    /**
     * Set the value of jugement
     *
     * @return  self
     */
    public function setJugement(?JugementEntity $jugement)
    {
        $this->jugement = $jugement;

        return $this;
    }
}
