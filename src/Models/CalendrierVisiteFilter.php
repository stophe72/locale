<?php

namespace App\Models;

class CalendrierVisiteFilter
{
    private $annee;

    /**
     * @var string
     */
    private $majeurNom;

    /**
     * Get the value of majeurNom
     *
     * @return  string
     */
    public function getMajeurNom(): ?string
    {
        return $this->majeurNom;
    }

    /**
     * Set the value of majeurNom
     *
     * @param  string  $majeurNom
     *
     * @return  self
     */
    public function setMajeurNom(?string $majeurNom)
    {
        $this->majeurNom = $majeurNom;

        return $this;
    }

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
}
