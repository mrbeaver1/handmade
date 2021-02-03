<?php

namespace App\Controller;

use App\DTO\CheckUserData;
use App\Exceptions\ApiHttpException\ApiNotFoundException;
use App\Repository\UserRepositoryInterface;
use App\VO\ApiErrorCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * @Route("/user", methods={"GET"})
     *
     * @param CheckUserData $checkUserData
     *
     * @return JsonResponse
     *
     * @throws ApiNotFoundException
     */
    public function showUser(CheckUserData $checkUserData): JsonResponse
    {
        $user = $this->userRepository->findByPhone($checkUserData->getPhoneNumber());

        if (empty($user)) {
            throw new ApiNotFoundException(
                ['Пользователь не найден'],
                new ApiErrorCode(ApiErrorCode::USER_NOT_FOUND)
            );
        }

        return new JsonResponse([
            'data' => [
                'id' => $user->getId(),
            ],
        ]);
    }
}
