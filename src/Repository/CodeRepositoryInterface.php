<?php

namespace App\Repository;

use App\Entity\Code;
use App\VO\Email;
use Doctrine\ORM\ORMException;

interface CodeRepositoryInterface
{
    /**
     * @param Email $email
     *
     * @return Code | null
     */
    public function findActiveByEmail(Email $email): ?Code;

    /**
     * @param Code $code
     *
     * @return void
     * @throws ORMException
     */
    public function add(Code $code): void;

    /**
     * @param Email  $email
     * @param string $code
     *
     * @return Code | null
     */
    public function findActiveByEmailAndValue(Email $email, string $code): ?Code;
}
