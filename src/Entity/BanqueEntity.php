<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BanqueRepository")
 * @ORM\Table(name="banque")
 * @UniqueEntity("libelle")
 */
class BanqueEntity extends BaseLibelleEntity
{
}
