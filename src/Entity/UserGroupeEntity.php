<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupeRepository")
 * @ORM\Table(name="userGroupe")
 * @UniqueEntity("libelle")
 */
class UserGroupeEntity extends BaseLibelleEntity
{
}
