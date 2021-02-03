<?php

namespace App\Repository;

use App\Entity\User;
use App\VO\PhoneNumber;

interface UserRepositoryInterface
{
    /**
     * @param PhoneNumber $phone
     *
     * @return User | null
     */
    public function findByPhone(PhoneNumber $phone): ?User;
}
