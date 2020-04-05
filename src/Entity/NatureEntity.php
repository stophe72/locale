<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureRepository")
 * @ORM\Table(name="nature")
 * @UniqueEntity("libelle")
 */
class NatureEntity extends BaseLibelleEntity
{
}
