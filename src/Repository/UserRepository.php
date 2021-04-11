<?php

namespace App\Repository;

use App\Entity\User;
use App\VO\Email;
use App\VO\PhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface, UserLoaderInterface
{
    /**
     * @param ManagerRegistry        $registry
     * @param EntityManagerInterface $em
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername(string $username)
    {
    }

    /**
     * @param Email $email
     *
     * @return User | null
     *
     * @throws NonUniqueResultException
     */
    public function findByEmail(Email $email): ?User
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->getValue())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Email $email
     *
     * @return User
     *
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): User
    {
        $builder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email->getValue());

        if (empty($builder)) {
            throw new EntityNotFoundException("Юзер с email {$email->getValue()} не найден");
        }

        return $builder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $id
     *
     * @return User
     *
     * @throws EntityNotFoundException
     */
    public function getById(int $id): User
    {
        $user = $this->findOneBy(['id' => $id]);

        if (empty($user)) {
            throw new EntityNotFoundException("Пользователь с id = $id не найден");
        }

        return $user;
    }
}
