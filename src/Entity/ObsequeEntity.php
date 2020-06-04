<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObsequeRepository")
 * @ORM\Table(name="obseque")
 * @UniqueEntity("majeur")
 */
class ObsequeEntity extends BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\OneToOne(targetEntity=MajeurEntity::class)
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\ManyToOne(targetEntity=PompeFunebreEntity::class)
     * @ORM\JoinColumn(name="pompeFunebreId", referencedColumnName="id", nullable=false)
     */
    private $pompeFunebre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contrat;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 1,
     *      max = 500,
     *      notInRangeMessage = "La durée de la concession doit être entre {{ min }} an et {{ max }} ans",
     * )
     *
     * @ORM\Column(name="dureeConcession", type="integer", nullable=true)
     */
    private $dureeConcession;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $cimetiere;

    /**
     * @ORM\Column(name="referenceConcession", type="string", length=100, nullable=true)
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

    public function getDureeConcession(): ?int
    {
        return $this->dureeConcession;
    }

    public function setDureeConcession(?int $dureeConcession): self
    {
        $this->dureeConcession = $dureeConcession;

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

    /**
     * Get the value of majeur
     */
    public function getMajeur()
    {
        return $this->majeur;
    }

    /**
     * Set the value of majeur
     *
     * @return  self
     */
    public function setMajeur($majeur)
    {
        $this->majeur = $majeur;

        return $this;
    }

    /**
     * Get the value of contrat
     *
     * @return  string
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Set the value of contrat
     *
     * @param  string  $contrat
     *
     * @return  self
     */
    public function setContrat(string $contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }
}
