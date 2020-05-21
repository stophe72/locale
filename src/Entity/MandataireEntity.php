<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MandataireRepository")
 * @ORM\Table(name="mandataire")
 */
class MandataireEntity extends BaseGroupeEntity
{
    /**
     * @var UserEntity
     *
     * @ORM\OneToOne(targetEntity="App\Entity\UserEntity")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     *
     * @var string
     */
    private $nom;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=false)
     *
     * @var string
     */
    private $prenom;

    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AdresseEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", referencedColumnName="id", nullable=false)
     *
     * @var AdresseEntity
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FicheFraisEntity", mappedBy="mandataire")
     */
    private $ficheFraisEntities;

    public function __construct()
    {
        $this->ficheFraisEntities = new ArrayCollection();
    }


    /**
     * Get the value of nom
     *
     * @return  string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param  string  $nom
     *
     * @return  self
     */
    public function setNom(string $nom)
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * Get the value of prenom
     *
     * @return  string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param  string  $prenom
     *
     * @return  self
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = ucfirst($prenom);

        return $this;
    }

    /**
     * Get the value of adresse
     *
     * @return  AdresseEntity
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @param  AdresseEntity  $adresse
     *
     * @return  self
     */
    public function setAdresse(AdresseEntity $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . ' ' . $this->getPrenom();
    }

    /**
     * Get the value of user
     *
     * @return  UserEntity
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param  UserEntity  $user
     *
     * @return  self
     */
    public function setUser(UserEntity $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|FicheFraisEntity[]
     */
    public function getFicheFraisEntities(): Collection
    {
        return $this->ficheFraisEntities;
    }

    public function addFicheFraisEntity(FicheFraisEntity $ficheFraisEntity): self
    {
        if (!$this->ficheFraisEntities->contains($ficheFraisEntity)) {
            $this->ficheFraisEntities[] = $ficheFraisEntity;
            $ficheFraisEntity->setMandataire($this);
        }

        return $this;
    }

    public function removeFicheFraisEntity(FicheFraisEntity $ficheFraisEntity): self
    {
        if ($this->ficheFraisEntities->contains($ficheFraisEntity)) {
            $this->ficheFraisEntities->removeElement($ficheFraisEntity);
            // set the owning side to null (unless already changed)
            if ($ficheFraisEntity->getMandataire() === $this) {
                $ficheFraisEntity->setMandataire(null);
            }
        }

        return $this;
    }
}
