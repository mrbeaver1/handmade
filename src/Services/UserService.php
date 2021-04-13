<?php

namespace App\Services;

use App\DTO\RegisterData;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\VO\Email;
use App\VO\Password;
use App\VO\UserId;
use App\VO\UserRole;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    private CodeService $codeService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface  $em
     * @param CodeService             $codeService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EntityManagerInterface $em,
        CodeService $codeService
    ) {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->codeService = $codeService;
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

        $this->codeService->sendSmsCode(new RegisterData($email));

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

    public function updatePhone(
        AuthTokenData $authTokenData,
        UserId $userId
    ): JsonResponse {

    }
}
