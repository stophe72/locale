<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeCompteRepository")
 * @ORM\Table(name="typeCompte")
 * @UniqueEntity("libelle")
 */
class TypeCompteEntity extends BaseLibelleEntity
{
}
