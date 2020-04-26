<?php

namespace App\Models;

class Jour
{
    private $numero;
    private $visite;

    public function __construct($numero = '', $visite = false)
    {
        $this->numero = $numero;
        $this->visite = $visite;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of visite
     */
    public function getVisite()
    {
        return $this->visite;
    }

    /**
     * Set the value of visite
     *
     * @return  self
     */
    public function setVisite($visite)
    {
        $this->visite = $visite;

        return $this;
    }
}
