<?php

namespace App\Fixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProvider
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * Function for Hash Fixtures password
     *
     * @param string $plainPass
     * @return string
     */
    public function hashUserPassword(string $plainPass): string
    {
        return $this->hasher->hashPassword(new User, $plainPass);
    }
}
