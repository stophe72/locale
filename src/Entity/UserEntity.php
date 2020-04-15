<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity("email")
 */
class UserEntity extends BaseEntity implements UserInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est pas une adresse valide."
     * )
     *
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @Assert\Length(
     *      min = 6,
     *      max = 30,
     *      minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe peut contenir au plus {{ limit }} caractères"
     * )
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotNull
     *
     * @var AdresseEntity
     */
    private $adresse;

    /**
     * @var boolean
     */
    private $administrateur;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of admin
     *
     * @return  boolean
     */
    public function isAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    /**
     * Set the value of admin
     *
     * @param  boolean  $admin
     *
     * @return  self
     */
    public function setAdministrateur(?bool $administrateur)
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    /**
     * Get the value of adresse
     *
     * @return  AdresseEntity
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @param  AdresseEntity  $adresse
     *
     * @return  self
     */
    public function setAdresse(AdresseEntity $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }
}
