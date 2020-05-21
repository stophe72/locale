<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeFraisRepository")
 * @ORM\Table(name="typeFrais")
 * @UniqueEntity("libelle")
 */
class TypeFraisEntity extends BaseGroupeLibelleEntity
{
}
