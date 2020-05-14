<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 * @ORM\Table(name="groupe")
 * @UniqueEntity("libelle")
 */
class GroupeEntity extends BaseLibelleEntity
{
}
