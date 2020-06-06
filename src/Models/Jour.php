<?php

namespace App\Models;

class Jour
{
    /**
     * @var int
     * 1..365
     */
    private $numero;

    /**
     * @var int
     * 0: rien
     * 1: present
     * 2: absent
     */
    private $presence;

    public function __construct($numero = '', $presence = 0)
    {
        $this->numero = $numero;
        $this->presence = $presence;
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
     * Get the value of presence
     */
    public function getPresence(): int
    {
        return $this->presence;
    }

    /**
     * Set the value of presence
     *
     * @return  self
     */
    public function setPresence(int $presence)
    {
        $this->presence = $presence;

        return $this;
    }
}
