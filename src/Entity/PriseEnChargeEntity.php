<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriseEnChargeRepository")
 * @ORM\Table(name="priseEnCharge")
 */
class PriseEnChargeEntity extends BaseEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePriseEnChargeEntity")
     * @ORM\JoinColumn(name="typePriseEnChargeId", referencedColumnName="id", nullable=false)
     */
    private $typePriseEnCharge;

    /**
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $traite;


    public function getTypePriseEnCharge(): ?TypePriseEnChargeEntity
    {
        return $this->typePriseEnCharge;
    }

    public function setTypePriseEnCharge(?TypePriseEnChargeEntity $typePriseEnCharge): self
    {
        $this->typePriseEnCharge = $typePriseEnCharge;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getTraite(): ?bool
    {
        return $this->traite;
    }

    public function setTraite(bool $traite): self
    {
        $this->traite = $traite;

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
}
