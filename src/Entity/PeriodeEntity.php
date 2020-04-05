<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodeRepository")
 * @ORM\Table(name="periode")
 */
class PeriodeEntity  extends BaseLibelleEntity
{
}
