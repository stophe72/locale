<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\Table(name="contact")
 */
class ContactEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $mobile;

    /**
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est une adresse valide."
     * )
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;


    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
