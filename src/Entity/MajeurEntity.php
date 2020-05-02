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
     * @ORM\OneToMany(targetEntity="App\Entity\DonneeBancaireEntity", mappedBy="majeur")
     * @ORM\JoinColumn(name="donneeBancaireId", referencedColumnName="id", nullable=false)
     */
    private $donneeBancaireEntities;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=25)
     */
    private $civilite;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(name="nomEtatCivil", type="string", length=100, nullable=true)
     */
    private $nomEtatCivil;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AdresseEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id",nullable=false)
     */
    private $adresse;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\JugementEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="jugementId", nullable=false, referencedColumnName="id")
     */
    private $jugement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContactEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", nullable=true, referencedColumnName="id")
     */
    private $contact;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=100)
     */
    private $lieuNaissance;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="numeroSS", type="string", length=100)
     */
    private $numeroSS;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ParametreMissionEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="parametreMissionId", referencedColumnName="id", nullable=false)
     */
    private $parametreMission;

    /**
     * @ORM\Column(name="dateFinCMU", type="date", nullable=true)
     */
    private $dateFinCMU;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nationalite;



    public function __construct()
    {
        $this->donneeBancaireEntities = new ArrayCollection();
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

    public function getNomEtatCivil(): ?string
    {
        return $this->nomEtatCivil;
    }

    public function setNomEtatCivil(?string $nomEtatCivil): self
    {
        $this->nomEtatCivil = $nomEtatCivil;

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

    public function getJugement(): ?JugementEntity
    {
        return $this->jugement;
    }

    public function setJugement(JugementEntity $jugement): self
    {
        $this->jugement = $jugement;

        return $this;
    }

    public function getContact(): ?ContactEntity
    {
        return $this->contact;
    }

    public function setContact(ContactEntity $contact): self
    {
        $this->contact = $contact;

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

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

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

    public function getParametreMission(): ?ParametreMissionEntity
    {
        return $this->parametreMission;
    }

    public function setParametreMission(ParametreMissionEntity $parametreMission): self
    {
        $this->parametreMission = $parametreMission;

        return $this;
    }

    public function getDateFinCMU(): ?\DateTimeInterface
    {
        return $this->dateFinCMU;
    }

    public function setDateFinCMU(?\DateTimeInterface $dateFinCMU): self
    {
        $this->dateFinCMU = $dateFinCMU;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function __toString()
    {
        return $this->nom . " " . $this->prenom;
    }
}
