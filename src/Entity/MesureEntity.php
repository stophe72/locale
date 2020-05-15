<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureRepository")
 * @ORM\Table(name="mesure")
 * @UniqueEntity("code")
 */
class MesureEntity extends BaseCodeLibelleEntity
{
    public function __toString()
    {
        return $this->getCode() . ' - ' . $this->getLibelle();
    }
}
