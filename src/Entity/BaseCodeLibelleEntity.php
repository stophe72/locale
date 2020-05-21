<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseCodeLibelleEntity extends BaseGroupeLibelleEntity
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Le code doit contenir au moins {{ limit }} caractère",
     *      maxMessage = "Le code doit contenir au plus {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="string", length=10)
     */
    private $code;


    /**
     * Get the value of code
     *
     * @return  string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  self
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }
}
