<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TribunalRepository")
 * @ORM\Table(name="tribunal")
 * @UniqueEntity("libelle")
 */
class TribunalEntity extends BaseGroupeLibelleEntity
{
}
