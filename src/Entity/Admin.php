<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Admin extends User
{
    protected $roles = ['ROLE_ADMIN'];
}
