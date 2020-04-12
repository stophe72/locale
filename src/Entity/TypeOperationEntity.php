<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeOperationRepository")
 * @ORM\Table(name="typeOperation")
 * @UniqueEntity("libelle")
 */
class TypeOperationEntity extends BaseLibelleEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
