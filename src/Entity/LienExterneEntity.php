<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LienExterneRepository")
 * @ORM\Table("lienExterne")
 */
class LienExterneEntity extends BaseGroupeLibelleEntity
{
    /**
     * @var string
     *
     * @Assert\Url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setLien(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
