<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImportOperationRepository")
 * @ORM\Table(name="importOperation")
 */
class ImportOperationEntity extends BaseLibelleEntity
{
    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\MajeurEntity")
     * @ORM\JoinColumn(name="majeurId", referencedColumnName="id", nullable=false)
     */
    private $majeur;

    /**
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOperationEntity")
     * @ORM\JoinColumn(name="typeOperationId", referencedColumnName="id", nullable=false)
     */
    private $typeOperation;

    /**
     * @var int
     *
     * @Assert\NotNull
     *
     * @ORM\Column(name="nature", type="integer", nullable=false)
     */
    private $nature;

    public function getMajeur(): ?MajeurEntity
    {
        return $this->majeur;
    }

    public function setMajeur(?MajeurEntity $majeur): self
    {
        $this->majeur = $majeur;

        return $this;
    }

    public function getTypeOperation(): ?TypeOperationEntity
    {
        return $this->typeOperation;
    }

    public function setTypeOperation(?TypeOperationEntity $typeOperation): self
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    /**
     * Get the value of nature
     *
     * @return  Integer
     */
    public function getNature(): ?int
    {
        return $this->nature;
    }

    /**
     * Set the value of nature
     *
     * @param  Integer  $nature
     *
     * @return  self
     */
    public function setNature(?int $nature)
    {
        $this->nature = $nature;

        return $this;
    }
}
