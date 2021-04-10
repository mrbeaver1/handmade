<?php

namespace App\Repository;

use App\Entity\Code;
use App\VO\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Code | null find($id, $lockMode = null, $lockVersion = null)
 * @method Code | null findOneBy(array $criteria, array $orderBy = null)
 * @method Code[]      findAll()
 * @method Code[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeRepository extends ServiceEntityRepository implements CodeRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Code::class);
    }

    /**
     * @param Email $email
     *
     * @return Code | null
     */
    public function findActiveByEmail(Email $email): ?Code
    {
        return $this->findOneBy([
            'email' => $email,
            'isActive' => true,
        ]);
    }

    /**
     * @param Code $code
     *
     * @return void
     * @throws ORMException
     */
    public function add(Code $code): void
    {
        $this->_em->persist($code);
    }

    /**
     * @param Email  $email
     * @param string $code
     *
     * @return Code | null
     */
    public function findActiveByEmailAndValue(Email $email, string $code): ?Code
    {
        return $this->findOneBy([
            'email' => $email,
            'code' => $code,
            'isActive' => true,
        ]);
    }
}
