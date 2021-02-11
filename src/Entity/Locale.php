<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocaleRepository")
 */
class Locale
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
     * @ORM\OneToMany(targetEntity=ProduitTranslation::class, mappedBy="locale")
     */
    private $produitTranslations;

    public function __construct()
    {
        $this->produitTranslations = new ArrayCollection();
    }


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
     * @return Collection|ProduitTranslation[]
     */
    public function getProduitTranslations(): Collection
    {
        return $this->produitTranslations;
    }

    public function addProduitTranslation(ProduitTranslation $produitTranslation): self
    {
        if (!$this->produitTranslations->contains($produitTranslation)) {
            $this->produitTranslations[] = $produitTranslation;
            $produitTranslation->setLocale($this);
        }

        return $this;
    }

    public function removeProduitTranslation(ProduitTranslation $produitTranslation): self
    {
        if ($this->produitTranslations->removeElement($produitTranslation)) {
            // set the owning side to null (unless already changed)
            if ($produitTranslation->getLocale() === $this) {
                $produitTranslation->setLocale(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId();
    }
}
