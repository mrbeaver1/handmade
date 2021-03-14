<?php

namespace App\Repository;

use App\Entity\User;
use App\VO\Email;
use Doctrine\ORM\NonUniqueResultException;

interface UserRepositoryInterface
{
    /**
     * @param Email $email
     *
     * @return User | null
     *
     * @throws NonUniqueResultException
     */
    public function findByEmail(Email $email): ?User;
}
