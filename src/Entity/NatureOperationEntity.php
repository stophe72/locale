<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureOperationRepository")
 * @ORM\Table(name="natureOperation")
 * @UniqueEntity(fields={"groupe", "libelle"})
 */
class NatureOperationEntity extends BaseGroupeLibelleEntity
{
}
