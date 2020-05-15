<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 * @ORM\Table(name="adresse")
 */
class AdresseEntity extends BaseEntity
{
    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $adresse1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adresse2;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="codePostal", type="string", length=10, nullable=false)
     */
    private $codePostal;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $ville;


    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(string $adresse1): self
    {
        $this->adresse1 = strtoupper($adresse1);

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = strtoupper($adresse2);

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = strtoupper($ville);

        return $this;
    }
}
