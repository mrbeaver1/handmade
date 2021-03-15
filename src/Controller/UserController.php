<?php

namespace App\Controller;

use App\DTO\CheckUserData;
use App\DTO\CreateUserData;
use App\Exception\ApiHttpException\ApiBadRequestException;
use App\Exception\ApiHttpException\ApiNotFoundException;
use App\Repository\UserRepositoryInterface;
use App\Services\UserService;
use App\VO\ApiErrorCode;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserService             $userService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserService $userService
    ) {
        parent::__construct($userRepository);

        $this->userService = $userService;
    }

    /**
     * @Route("/user", methods={"GET"})
     *
     * @param CheckUserData $checkUserData
     *
     * @return JsonResponse
     *
     * @throws NonUniqueResultException
     */
    public function showUser(CheckUserData $checkUserData): JsonResponse
    {
        $user = $this->userRepository->findByEmail($checkUserData->getEmail());

        if (empty($user)) {
            throw new ApiNotFoundException(
                ['Пользователь не найден'],
                new ApiErrorCode(ApiErrorCode::USER_NOT_FOUND)
            );
        }
        return new JsonResponse([
            'data' => [
                $user->toArray(),
            ],
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/user", methods={"POST"})
     *
     * @param CreateUserData $createUserData
     *
     * @return JsonResponse
     *
     * @throws NonUniqueResultException
     */
    public function createUser(CreateUserData $createUserData): JsonResponse
    {
        if (!is_null($this->userRepository->findByEmail($createUserData->getEmail()))) {
            throw new ApiBadRequestException(
                ["Юзер с email {$createUserData->getEmail()->getValue()}"],
                new ApiErrorCode(ApiErrorCode::ENTITY_EXISTS)
            );
        }

        $user = $this->userService->createUser($createUserData->getEmail());

        return new JsonResponse([
            'data' => $user->toArray(),
        ], JsonResponse::HTTP_CREATED);
    }
}
