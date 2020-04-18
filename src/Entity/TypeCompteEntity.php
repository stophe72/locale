<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeCompteRepository")
 * @ORM\Table(name="typeCompte")
 * @UniqueEntity("libelle")
 */
class TypeCompteEntity extends BaseLibelleEntity
{
    /**
     * @var FamilleCompteEntity
     *
     * @Assert\NotBlank
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FamilleCompteEntity")
     * @ORM\JoinColumn(name="familleCompteId", referencedColumnName="id", nullable=true)
     */
    private $familleCompte;

    public function getFamilleCompte(): ?FamilleCompteEntity
    {
        return $this->familleCompte;
    }

    public function setFamilleCompte(?FamilleCompteEntity $familleCompte): self
    {
        $this->familleCompte = $familleCompte;

        return $this;
    }
}
