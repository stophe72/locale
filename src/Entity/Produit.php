<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @var Collection
     *
     * @ORM\OneToOne(targetEntity="ProduitTranslation", mappedBy="produit", cascade={"persist"})
     */
    private $produitTranslations;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of produitTranslations
     *
     * @return  Collection
     */
    public function getProduitTranslations()
    {
        return $this->produitTranslations;
    }

    /**
     * Set the value of produitTranslations
     *
     * @param  Collection  $produitTranslations
     *
     * @return  self
     */
    public function setProduitTranslations(Collection $produitTranslations)
    {
        $this->produitTranslations = $produitTranslations;

        return $this;
    }
}
