<?php

namespace App\Models;

use App\Entity\TypeOperationEntity;
use DateTimeInterface;

class CompteGestionFilter
{
    /**
     * @var DateTimeInterface
     */
    private $dateDebut;

    /**
     * @var DateTimeInterface
     */
    private $dateFin;

    /**
     * @var string
     */
    private $majeurNom;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var TypeOperationEntity
     */
    private $typeOperation;

    /**
     * @var float
     */
    private $montant;


    /**
     * Get the value of dateDebut
     *
     * @return  DateTimeInterface
     */
    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @param  DateTimeInterface  $dateDebut
     *
     * @return  self
     */
    public function setDateDebut(?DateTimeInterface $dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get the value of dateFin
     *
     * @return  DateTimeInterface
     */
    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * Set the value of dateFin
     *
     * @param  DateTimeInterface  $dateFin
     *
     * @return  self
     */
    public function setDateFin(?DateTimeInterface $dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get the value of typeOperation
     *
     * @return  TypeOperationEntity
     */
    public function getTypeOperation(): ?TypeOperationEntity
    {
        return $this->typeOperation;
    }

    /**
     * Set the value of typeOperation
     *
     * @param  TypeOperationEntity  $typeOperation
     *
     * @return  self
     */
    public function setTypeOperation(?TypeOperationEntity $typeOperation)
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    /**
     * Get the value of majeurNom
     *
     * @return string
     */
    public function getMajeurNom(): ?string
    {
        return $this->majeurNom;
    }

    /**
     * Set the value of majeurNom
     *
     * @param  string $majeurNom
     *
     * @return  self
     */
    public function setMajeurNom(?string $majeurNom)
    {
        $this->majeurNom = $majeurNom;

        return $this;
    }

    /**
     * Get the value of montant
     *
     * @return  float
     */
    public function getMontant(): ?float
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @param  float  $montant
     *
     * @return  self
     */
    public function setMontant(?float $montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Set the value of libelle
     *
     * @param  string  $libelle
     *
     * @return  self
     */
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of libelle
     *
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}
