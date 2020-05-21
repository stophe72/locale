<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleCompteRepository")
 * @ORM\Table(name="familleCompte")
 * @UniqueEntity("libelle")
 */
class FamilleCompteEntity extends BaseGroupeLibelleEntity
{
}
