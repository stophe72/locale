<?php

namespace App\Models;

use Symfony\Component\Validator\Constraints as Assert;

class ImportCompteGestion
{
    /**
     * @Assert\NotBlank
     *
     * @var string
     */
    private $nomFichier;

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
