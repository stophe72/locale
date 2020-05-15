<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametreMissionRepository")
 * @ORM\Table(name="parametreMission")
 */
class ParametreMissionEntity extends BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MesureEntity")
     * @ORM\JoinColumn(name="mesureId", referencedColumnName="id", nullable=false)
     */
    private $mesure;

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


    public function getMesure(): ?MesureEntity
    {
        return $this->mesure;
    }

    public function setMesure(?MesureEntity $mesure): self
    {
        $this->mesure = $mesure;

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
