<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactExterneRepository")
 * @ORM\Table(name="contactExterne")
 */
class ContactExterneEntity extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=MajeurEntity::class, inversedBy="contactExterneEntities")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\OneToOne(targetEntity=ContactEntity::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="contactId", nullable=false)
     */
    private $contact;


    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(?MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = strtoupper($nom);

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
