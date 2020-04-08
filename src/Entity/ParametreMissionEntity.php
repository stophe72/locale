<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParametreMissionRepository")
 * @ORM\Table(name="parametreMission")
 */
class ParametreMissionEntity extends BaseUserEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NatureEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProtectionEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $protection;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LieuVieEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieuVie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PeriodeEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PrestationSocialeEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prestationSociale;

    /**
     * @ORM\Column(type="float")
     */
    private $ressources;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MajeurEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $majeur;

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

    public function getPeriode(): ?PeriodeEntity
    {
        return $this->periode;
    }

    public function setPeriode(?PeriodeEntity $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getPrestationSociale(): ?PrestationSocialeEntity
    {
        return $this->prestationSociale;
    }

    public function setPrestationSociale(?PrestationSocialeEntity $prestationSociale): self
    {
        $this->prestationSociale = $prestationSociale;

        return $this;
    }

    public function getRessources(): ?float
    {
        return $this->ressources;
    }

    public function setRessources(float $ressources): self
    {
        $this->ressources = $ressources;

        return $this;
    }

    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }
}
