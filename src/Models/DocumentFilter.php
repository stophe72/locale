<?php

namespace App\Models;

use App\Entity\MajeurEntity;

class DocumentFilter
{
    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $observations;

    /**
     * @var MajeurEntity
     */
    private $majeur;

    /**
     * Get the value of libelle
     *
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
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
     * Get the value of observations
     *
     * @return  string
     */
    public function getObservations(): ?string
    {
        return $this->observations;
    }

    /**
     * Set the value of observations
     *
     * @param  string  $observations
     *
     * @return  self
     */
    public function setObservations(?string $observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get the value of majeur
     *
     * @return  MajeurEntity
     */
    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    /**
     * Set the value of majeur
     *
     * @param  Majeur  $majeur
     *
     * @return  self
     */
    public function setMajeur(?MajeurEntity $majeur)
    {
        $this->majeur = $majeur;

        return $this;
    }
}
