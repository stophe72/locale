<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureRepository")
 * @ORM\Table(name="nature")
 * @UniqueEntity("code")
 */
class NatureEntity extends BaseLibelleEntity
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * Get the value of code
     *
     * @return  string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  self
     */
    public function setCode(string $code)
    {
        $this->code = strtoupper($code);

        return $this;
    }

    public function __toString()
    {
        return $this->getCode() . ' - ' . $this->getLibelle();
    }
}
