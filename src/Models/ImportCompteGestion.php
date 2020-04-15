<?php

namespace App\Models;

use App\Entity\MajeurEntity;

class ImportCompteGestion
{
    /**
     * @var MajeurEntity
     */
    private $majeur;

    /**
     * @var string
     */
    private $nomFichier;

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

    /**
     * Get the value of nomFichier
     *
     * @return  string
     */
    public function getNomFichier()
    {
        return $this->nomFichier;
    }

    /**
     * Set the value of nomFichier
     *
     * @param  string  $nomFichier
     *
     * @return  self
     */
    public function setNomFichier(string $nomFichier)
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }
}