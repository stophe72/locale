<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MandataireRepository")
 * @ORM\Table(name="mandataire")
 */
class MandataireEntity extends BaseUserEntity
{
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
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupeEntity")
     * @ORM\JoinColumn(name="groupeId", referencedColumnName="id", nullable=false)
     *
     * @var GroupeEntity
     */
    private $groupe;


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

    /**
     * Get the value of groupe
     *
     * @return  GroupeEntity
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set the value of groupe
     *
     * @param  GroupeEntity  $groupe
     *
     * @return  self
     */
    public function setGroupe(GroupeEntity $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . ' ' . $this->getPrenom();
    }
}
