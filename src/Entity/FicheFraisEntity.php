<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheFraisRepository")
 * @ORM\Table(name="ficheFrais")
 */
class FicheFraisEntity extends BaseEntity
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteDeFraisEntity", mappedBy="ficheFrais")
     */
    private $noteDeFraisEntities;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MandataireEntity", inversedBy="ficheFraisEntities")
     * @ORM\JoinColumn(name="mandataireId", referencedColumnName="id", nullable=false)
     */
    private $mandataire;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le libellé doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le libellé doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $libelle;


    public function __construct()
    {
        $this->noteDeFraisEntities = new ArrayCollection();
    }

    /**
     * @return Collection|NoteDeFraisEntity[]
     */
    public function getNoteDeFraisEntities(): Collection
    {
        return $this->noteDeFraisEntities;
    }

    public function addNoteDeFraisEntity(NoteDeFraisEntity $noteDeFraisEntity): self
    {
        if (!$this->noteDeFraisEntities->contains($noteDeFraisEntity)) {
            $this->noteDeFraisEntities[] = $noteDeFraisEntity;
            $noteDeFraisEntity->setFicheFrais($this);
        }

        return $this;
    }

    public function removeNoteDeFraisEntity(NoteDeFraisEntity $noteDeFraisEntity): self
    {
        if ($this->noteDeFraisEntities->contains($noteDeFraisEntity)) {
            $this->noteDeFraisEntities->removeElement($noteDeFraisEntity);
            // set the owning side to null (unless already changed)
            if ($noteDeFraisEntity->getFicheFrais() === $this) {
                $noteDeFraisEntity->setFicheFrais(null);
            }
        }

        return $this;
    }

    public function getMandataire(): ?MandataireEntity
    {
        return $this->mandataire;
    }

    public function setMandataire(?MandataireEntity $mandataire): self
    {
        $this->mandataire = $mandataire;

        return $this;
    }

    /**
     * Get )
     *
     * @return  string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set )
     *
     * @param  string  $libelle  )
     *
     * @return  self
     */
    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
