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
     * @ORM\OneToOne(targetEntity=ContactEntity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", nullable=false)
     */
    private $contact;

    /**
     * @Assert\NotBlank
     *
     * @ORM\Column(name="codeBanque", type="string", length=30, nullable=false)
     */
    private $codeBanque;

    /**
     * @var string
     *
     * @ORM\Column(name="conseiller", type="string", length=100, nullable=true)
     */
    private $conseiller;

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
     * Get the value of conseiller
     *
     * @return  string
     */
    public function getConseiller()
    {
        return $this->conseiller;
    }

    /**
     * Set the value of conseiller
     *
     * @param  string  $conseiller
     *
     * @return  self
     */
    public function setConseiller(string $conseiller)
    {
        $this->conseiller = strtoupper($conseiller);

        return $this;
    }
}
