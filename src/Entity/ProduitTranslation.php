<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitTranslationRepository::class)
 */
class ProduitTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Produit::class, cascade={"persist", "remove"}, inversedBy="produitTranslations")
     * @ORM\JoinColumn(name="produit_id", nullable=false)
     */
    private $produit;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $texte;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class, inversedBy="produitTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locale;


    public function __construct()
    {
        $this->localeId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
