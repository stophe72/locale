<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PompeFunebreRepository")
 * @ORM\Table(name="pompeFunebre")
 */
class PompeFunebreEntity extends BaseGroupeLibelleEntity
{
    /**
     * @ORM\OneToOne(targetEntity=AdresseEntity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresseId", nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=ContactEntity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", nullable=false)
     */
    private $contact;

    public function getAdresse(): ?AdresseEntity
    {
        return $this->adresse;
    }

    public function setAdresse(AdresseEntity $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContact(): ?ContactEntity
    {
        return $this->contact;
    }

    public function setContact(ContactEntity $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
