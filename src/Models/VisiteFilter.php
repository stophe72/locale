<?php

namespace App\Models;

use DateTimeInterface;

class VisiteFilter
{
    /**
     * @var DateTimeInterface
     */
    private $dateDebut;

    /**
     * @var DateTimeInterface
     */
    private $dateFin;

    /**
     * @var string
     */
    private $majeurNom;

    private $majeurId;


    /**
     * Get the value of dateDebut
     *
     * @return  DateTimeInterface
     */
    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of dateDebut
     *
     * @param  DateTimeInterface  $dateDebut
     *
     * @return  self
     */
    public function setDateDebut(?DateTimeInterface $dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get the value of dateFin
     *
     * @return  DateTimeInterface
     */
    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * Set the value of dateFin
     *
     * @param  DateTimeInterface  $dateFin
     *
     * @return  self
     */
    public function setDateFin(?DateTimeInterface $dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get the value of majeurNom
     *
     * @return  string
     */
    public function getMajeurNom(): ?string
    {
        return $this->majeurNom;
    }

    /**
     * Set the value of majeurNom
     *
     * @param  string  $majeurNom
     *
     * @return  self
     */
    public function setMajeurNom(?string $majeurNom)
    {
        $this->majeurNom = $majeurNom;

        return $this;
    }

    /**
     * Get the value of majeurId
     */
    public function getMajeurId()
    {
        return $this->majeurId;
    }

    /**
     * Set the value of majeurId
     *
     * @return  self
     */
    public function setMajeurId($majeurId)
    {
        $this->majeurId = $majeurId;

        return $this;
    }
}
