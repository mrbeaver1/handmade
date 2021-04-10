<?php

namespace App\Services;

use App\DTO\RegisterData;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\VO\Email;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

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
     * @var MailerService
     */
    private MailerService $mailerService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface $em
     * @param MailerService $mailerService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EntityManagerInterface $em,
        MailerService $mailerService
    ) {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->mailerService = $mailerService;
    }

    /**
     * @param Email $email
     *
     * @return User
     * @throws ORMException
     */
    public function createUser(Email $email): User
    {
        $user = new User($email);

        $this->em->persist($user);
        $this->em->flush();

        $this->mailerService->sendSmsCode(new RegisterData($email));

        return $user;
    }
}
