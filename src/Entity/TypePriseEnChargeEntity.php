<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePriseEnChargeRepository")
 * @ORM\Table(name="typePriseEnCharge")
 */
class TypePriseEnChargeEntity extends BaseCodeLibelleEntity
{
    /**
     * @var bool
     *
     * @Assert\NotNull
     *
     * @ORM\Column(type="boolean")
     */
    private $alertable;


    public function getAlertable(): ?bool
    {
        return $this->alertable;
    }

    public function setAlertable(bool $alertable): self
    {
        $this->alertable = $alertable;

        return $this;
    }
}
