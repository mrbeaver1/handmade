<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\VO\Email;
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
     * @param Email $email
     *
     * @return User
     */
    public function createUser(Email $email): User
    {
        $user = new User($email);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
