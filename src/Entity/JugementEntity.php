<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugementRepository")
 * @ORM\Table(name="jugement")
 * @UniqueEntity("majeur")
 */
class JugementEntity extends BaseEntity
{
    /**
     * @var MajeurEntity
     *
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @Assert\NotBlank
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
     * @Assert\NotBlank
     *
     * @ORM\Column(name="dateJugement", type="date", nullable=false)
     */
    private $dateJugement;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="debutMesure", type="date", nullable=false)
     */
    private $debutMesure;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="finMesure", type="date", nullable=false)
     */
    private $finMesure;

    /**
     * Get the value of numeroRG
     */
    public function getNumeroRG()
    {
        return $this->numeroRG;
    }

    /**
     * Set the value of numeroRG
     *
     * @return  self
     */
    public function setNumeroRG($numeroRG)
    {
        $this->numeroRG = $numeroRG;

        return $this;
    }

    /**
     * Get the value of tribunal
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }

    /**
     * Set the value of tribunal
     *
     * @return  self
     */
    public function setTribunal($tribunal)
    {
        $this->tribunal = $tribunal;

        return $this;
    }

    /**
     * Get the value of dateJugement
     */
    public function getDateJugement()
    {
        return $this->dateJugement;
    }

    /**
     * Set the value of dateJugement
     *
     * @return  self
     */
    public function setDateJugement($dateJugement)
    {
        $this->dateJugement = $dateJugement;

        return $this;
    }

    /**
     * Get the value of debutMesure
     */
    public function getDebutMesure()
    {
        return $this->debutMesure;
    }

    /**
     * Set the value of debutMesure
     *
     * @return  self
     */
    public function setDebutMesure($debutMesure)
    {
        $this->debutMesure = $debutMesure;

        return $this;
    }

    /**
     * Get the value of finMesure
     */
    public function getFinMesure()
    {
        return $this->finMesure;
    }

    /**
     * Set the value of finMesure
     *
     * @return  self
     */
    public function setFinMesure($finMesure)
    {
        $this->finMesure = $finMesure;

        return $this;
    }

    /**
     * Get the value of majeur
     *
     * @return  MajeurEntity
     */
    public function getMajeur()
    {
        return $this->majeur;
    }

    /**
     * Set the value of majeur
     *
     * @param  MajeurEntity  $majeur
     *
     * @return  self
     */
    public function setMajeur(MajeurEntity $majeur)
    {
        $this->majeur = $majeur;

        return $this;
    }
}
