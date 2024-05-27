<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;

    /**
     * @Assert\NotBlank
     */
    public $firstName;

    /**
     * @Assert\NotBlank
     */
    public $lastName;
}