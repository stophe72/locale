<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImportOperationRepository")
 * @ORM\Table(name="importOperation")
 */
class ImportOperationEntity extends BaseGroupeLibelleEntity
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

    /**
     * @var int
     *
     * @Assert\NotNull
     *
     * @ORM\Column(name="caseSensible", type="boolean", nullable=true)
     */
    private $caseSensible;


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

    /**
     * Get the value of caseSensible
     *
     * @return  int
     */
    public function isCaseSensible()
    {
        return $this->caseSensible;
    }

    /**
     * Set the value of caseSensible
     *
     * @param  int  $caseSensible
     *
     * @return  self
     */
    public function setCaseSensible(int $caseSensible)
    {
        $this->caseSensible = $caseSensible;

        return $this;
    }
}
