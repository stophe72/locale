<?php

namespace App\Models;

class CalendrierVisiteFilter2
{
    private $jour;

    private $mois;

    private $annee;

    private $majeurId;

    /**
     * Get the value of annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set the value of annee
     *
     * @return  self
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get the value of majeurId
     */
    public function getMajeurId()
    {
        return $this->majeurId;
    }

    /**
     * Set the value of majeurId
     *
     * @return  self
     */
    public function setMajeurId($majeurId)
    {
        $this->majeurId = $majeurId;

        return $this;
    }

    /**
     * Get the value of mois
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set the value of mois
     *
     * @return  self
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get the value of jour
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set the value of jour
     *
     * @return  self
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }
}
