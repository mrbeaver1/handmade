<?php

namespace App\Services;

use App\DTO\RegisterData;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\VO\Email;
use App\VO\Password;
use App\VO\PhoneNumber;
use App\VO\UserRole;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
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
     * @var CodeService
     */
    private CodeService $mailerService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface $em
     * @param CodeService $mailerService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EntityManagerInterface $em,
        CodeService $mailerService
    ) {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->mailerService = $mailerService;
    }

    /**
     * @param Email $email
     *
     * @return User
     *
     * @throws ORMException
     */
    public function createUser(Email $email): User
    {
        $user = new User($email, new UserRole(UserRole::USER));

        $this->em->persist($user);
        $this->em->flush();

        $this->mailerService->sendSmsCode(new RegisterData($email));

        return $user;
    }

    /**
     * @param Email    $email
     * @param Password $password
     *
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function restorePassword(Email $email, Password $password): void
    {
        $this->userRepository->getByEmail($email)
            ->updatePassword($password);

        $this->em->flush();
    }
}
