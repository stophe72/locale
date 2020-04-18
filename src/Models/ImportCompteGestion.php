<?php

namespace App\Models;

use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use Symfony\Component\Validator\Constraints as Assert;

class ImportCompteGestion
{
    /**
     * @Assert\NotNull
     *
     * @var MajeurEntity
     */
    private $majeur;

    /**
     * @var DonneeBancaireEntity
     *
     * @Assert\NotNull
     *
     * @var DonneeBancaireEntity
     */
    private $donneeBancaire;

    /**
     * @Assert\NotBlank
     *
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

    /**
     * Get the value of donneeBancaire
     *
     * @return  DonneeBancaireEntity
     */
    public function getDonneeBancaire()
    {
        return $this->donneeBancaire;
    }

    /**
     * Set the value of donneeBancaire
     *
     * @param  DonneeBancaireEntity  $donneeBancaire
     *
     * @return  self
     */
    public function setDonneeBancaire(DonneeBancaireEntity $donneeBancaire)
    {
        $this->donneeBancaire = $donneeBancaire;

        return $this;
    }
}
