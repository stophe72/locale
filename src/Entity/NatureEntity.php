<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureRepository")
 * @ORM\Table(name="nature")
 * @UniqueEntity("code")
 */
class NatureEntity extends BaseCodeLibelleEntity
{
    public function __toString()
    {
        return $this->getCode() . ' - ' . $this->getLibelle();
    }
}
