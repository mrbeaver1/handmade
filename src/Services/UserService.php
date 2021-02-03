<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\EntityException\EntityExistsException;
use App\Repository\UserRepositoryInterface;
use App\VO\PhoneNumber;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface  $em
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EntityManagerInterface $em
    ) {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @param PhoneNumber $phoneNumber
     *
     * @return User
     *
     * @throws EntityExistsException
     */
    public function createUser(PhoneNumber $phoneNumber): User
    {
        $user = $this->userRepository->findByPhone($phoneNumber);

        if (!empty($user)) {
            throw new EntityExistsException(
                "Юзер с номером телефона {$phoneNumber->getValue()} уже существует в системе"
            );
        }

        $user = new User($phoneNumber);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
