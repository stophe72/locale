<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuVieRepository")
 * @ORM\Table(name="lieuVie")
 * @UniqueEntity("libelle")
 */
class LieuVieEntity extends BaseLibelleEntity
{
}
