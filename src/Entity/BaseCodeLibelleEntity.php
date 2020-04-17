<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseCodeLibelleEntity extends BaseLibelleEntity
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Le code doit contenir au moins {{ limit }} caractère",
     *      maxMessage = "Le code doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     */
    private $code;


    /**
     * Get min = 2,
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set min = 2,
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = strtoupper($code);

        return $this;
    }
}
