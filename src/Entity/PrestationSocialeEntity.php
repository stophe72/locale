<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrestationSocialeRepository")
 * @ORM\Table(name="prestationSociale")
 * @UniqueEntity("libelle")
 */
class PrestationSocialeEntity extends BaseLibelleEntity
{
}
