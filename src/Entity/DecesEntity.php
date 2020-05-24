<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="deces")
 */
class DecesEntity extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=PompeFunebreEntity::class)
     * @ORM\JoinColumn(name="pompeFunebreId", referencedColumnName="id", nullable=false)
     */
    private $pompeFunebre;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $concession;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $cimetiere;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $referenceConcession;


    public function getPompeFunebre(): ?PompeFunebreEntity
    {
        return $this->pompeFunebre;
    }

    public function setPompeFunebre(?PompeFunebreEntity $pompeFunebre): self
    {
        $this->pompeFunebre = $pompeFunebre;

        return $this;
    }

    public function getConcession(): ?string
    {
        return $this->concession;
    }

    public function setConcession(?string $concession): self
    {
        $this->concession = $concession;

        return $this;
    }

    public function getCimetiere(): ?string
    {
        return $this->cimetiere;
    }

    public function setCimetiere(?string $cimetiere): self
    {
        $this->cimetiere = $cimetiere;

        return $this;
    }

    public function getReferenceConcession(): ?string
    {
        return $this->referenceConcession;
    }

    public function setReferenceConcession(?string $referenceConcession): self
    {
        $this->referenceConcession = $referenceConcession;

        return $this;
    }
}
