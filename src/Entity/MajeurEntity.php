<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MajeurRepository")
 * @ORM\Table(name="majeur")
 */
class MajeurEntity extends BaseGroupeEntity
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DonneeBancaireEntity", mappedBy="majeur")
     * @ORM\JoinColumn(name="donneeBancaireId", referencedColumnName="id", nullable=false)
     */
    private $donneeBancaireEntities;

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
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id",nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContactEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", nullable=true, referencedColumnName="id")
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
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", nullable=false)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=ContactExterneEntity::class, mappedBy="majeur", orphanRemoval=true)
     */
    private $contactExterneEntities;


    public function __construct()
    {
        $this->donneeBancaireEntities = new ArrayCollection();
        $this->contactExterneEntities = new ArrayCollection();
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
        $this->nom = strtoupper($nom);

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
        $this->lieuNaissance = strtoupper($lieuNaissance);

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
        return $this->prenom . " " . $this->nom;
    }

    /**
     * Get the value of image
     *
     * @return  string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @param  string  $image
     *
     * @return  self
     */
    public function setImage(?string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }

    /**
     * Get the value of slug
     *
     * @return  string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @param  string  $slug
     *
     * @return  self
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|ContactExterneEntity[]
     */
    public function getContactExterneEntities(): Collection
    {
        return $this->contactExterneEntities;
    }

    public function addContactExterneEntity(ContactExterneEntity $contactExterneEntity): self
    {
        if (!$this->contactExterneEntities->contains($contactExterneEntity)) {
            $this->contactExterneEntities[] = $contactExterneEntity;
            $contactExterneEntity->setMajeur($this);
        }

        return $this;
    }

    public function removeContactExterneEntity(ContactExterneEntity $contactExterneEntity): self
    {
        if ($this->contactExterneEntities->contains($contactExterneEntity)) {
            $this->contactExterneEntities->removeElement($contactExterneEntity);
            // set the owning side to null (unless already changed)
            if ($contactExterneEntity->getMajeur() === $this) {
                $contactExterneEntity->setMajeur(null);
            }
        }

        return $this;
    }
}
