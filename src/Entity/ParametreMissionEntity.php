<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametreMissionRepository")
 * @ORM\Table(name="parametreMission")
 */
class ParametreMissionEntity extends BaseUserEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\NatureEntity")
     * @ORM\JoinColumn(name="natureId", referencedColumnName="id", nullable=false)
     */
    private $nature;

    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ProtectionEntity")
     * @ORM\JoinColumn(name="protectionId", referencedColumnName="id", nullable=false)
     */
    private $protection;

    /**
     * @Assert\NotNull
     *

     * @ORM\ManyToOne(targetEntity="App\Entity\LieuVieEntity")
     * @ORM\JoinColumn(name="lieuVieId", referencedColumnName="id", nullable=false)
     */
    private $lieuVie;


    public function getNature(): ?NatureEntity
    {
        return $this->nature;
    }

    public function setNature(?NatureEntity $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getProtection(): ?ProtectionEntity
    {
        return $this->protection;
    }

    public function setProtection(?ProtectionEntity $protection): self
    {
        $this->protection = $protection;

        return $this;
    }

    public function getLieuVie(): ?LieuVieEntity
    {
        return $this->lieuVie;
    }

    public function setLieuVie(?LieuVieEntity $lieuVie): self
    {
        $this->lieuVie = $lieuVie;

        return $this;
    }
}
