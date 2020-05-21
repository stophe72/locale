<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgenceBancaireRepository")
 * @ORM\Table(name="agenceBancaire")
 * @UniqueEntity("libelle")
 */
class AgenceBancaireEntity extends BaseGroupeLibelleEntity
{
    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $telephone;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contact;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="codeBanque", type="string", length=30, nullable=false)
     */
    private $codeBanque;

    /**
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est une adresse valide."
     * )
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * Get message = "L'adresse email '{{ value }}' n'est une adresse valide."
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message = "L'adresse email '{{ value }}' n'est une adresse valide."
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set the value of contact
     *
     * @return  self
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }

    /**
     * Get the value of codeBanque
     */
    public function getCodeBanque()
    {
        return $this->codeBanque;
    }

    /**
     * Set the value of codeBanque
     *
     * @return  self
     */
    public function setCodeBanque($codeBanque)
    {
        $this->codeBanque = strtoupper($codeBanque);

        return $this;
    }
}
