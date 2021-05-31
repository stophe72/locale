<?php

namespace App\Models;

use App\Entity\CompteGestionEntity;
use Doctrine\Common\Collections\ArrayCollection;

class CompteGestionImport
{
    /**
     * @var ArrayCollection
     */
    private $compteGestions;

    public function __construct()
    {
        $this->compteGestions = new ArrayCollection();
    }

    /**
     * Get the value of compteGestions
     *
     * @return  ArrayCollection
     */
    public function getCompteGestions(): ArrayCollection
    {
        return $this->compteGestions;
    }

    /**
     * Set the value of compteGestions
     *
     * @param  ArrayCollection  $compteGestions
     *
     * @return  self
     */
    public function setCompteGestions(ArrayCollection $compteGestions)
    {
        $this->compteGestions = $compteGestions;

        return $this;
    }

    public function addCompteGestion(CompteGestionEntity $compteGestion) {
        $this->compteGestions->add($compteGestion);
    }

    public function removeCompteGestion(CompteGestionEntity $compteGestion) {
        $this->compteGestions->remove($compteGestion);
    }
}
