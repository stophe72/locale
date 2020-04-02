<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseLibelleEntity extends BaseUserEntity
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le libellé doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le libellé doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * Get min = 2,
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set min = 2,
     *
     * @return  self
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }
}
