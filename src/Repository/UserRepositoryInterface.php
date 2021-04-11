<?php

namespace App\Repository;

use App\Entity\User;
use App\VO\Email;
use Doctrine\ORM\EntityNotFoundException;
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

    /**
     * @param Email $email
     *
     * @return User
     *
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): User;

    /**
     * @param int $id
     *
     * @return User
     *
     * @throws EntityNotFoundException
     */
    public function getById(int $id): User;
}
