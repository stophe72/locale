<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProtectionRepository")
 * @ORM\Table(name="protection")
 * @UniqueEntity("libelle")
 */
class ProtectionEntity extends BaseGroupeLibelleEntity
{
}
