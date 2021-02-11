<?php

namespace App\Model\Structure;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class User
{
    private $nom;
    private $email;

    /**
     * @var bool
     */
    private $contact;

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of contact
     *
     * @return  bool
     */
    public function isContact()
    {
        return $this->contact;
    }

    /**
     * Set the value of contact
     *
     * @param  bool  $contact
     *
     * @return  self
     */
    public function setContact(bool $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->isContact() && empty($this->getEmail())) {
            $context->buildViolation('Si contact, alors l\'email ne peut être vide !')
                ->atPath('email')
                ->addViolation();
        }
    }
}
