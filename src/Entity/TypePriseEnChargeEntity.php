<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePriseEnChargeRepository")
 * @ORM\Table(name="typePriseEnCharge")
 * @UniqueEntity(fields={"groupe", "libelle"})
 */
class TypePriseEnChargeEntity extends BaseCodeLibelleEntity
{

    /**
     * @ORM\Column(name="seuilAlerte", type="integer", nullable=true)
     */
    private $seuilAlerte;

    /**
     * Get the value of seuilAlerte
     */
    public function getSeuilAlerte()
    {
        return $this->seuilAlerte;
    }

    /**
     * Set the value of seuilAlerte
     *
     * @return  self
     */
    public function setSeuilAlerte($seuilAlerte)
    {
        $this->seuilAlerte = $seuilAlerte;

        return $this;
    }
}
