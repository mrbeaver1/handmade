<?php

namespace App\Controller;

use App\DTO\CheckUserData;
use App\DTO\CreateUserData;
use App\DTO\RegisterData;
use App\DTO\RestoreData;
use App\DTO\SendSmsData;
use App\Entity\User;
use App\Exception\ApiHttpException\ApiBadRequestException;
use App\Exception\ApiHttpException\ApiNotFoundException;
use App\Repository\UserRepositoryInterface;
use App\Services\MailerService;
use App\Services\UserService;
use App\VO\ApiErrorCode;
use App\VO\SmsTemplate;
use App\VO\UserId;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var MailerService
     */
    private MailerService $mailerService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserService             $userService
     * @param MailerService           $mailerService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserService $userService,
        MailerService $mailerService
    ) {
        parent::__construct($userRepository);

        $this->userService = $userService;
        $this->mailerService = $mailerService;
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
     * @throws ORMException
     * @throws TransportExceptionInterface
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

    /**
     * Создаёт и отправляет смс код при регистрации или восстановлении пароля юзером
     *
     * @Route("/user/{user_id}/code", methods={"PUT"})
     *
     * @param UserId $userId
     * @param SendSmsData $sendSmsData
     *
     * @return JsonResponse
     *
     * @throws ORMException
     * @throws TransportExceptionInterface
     * @throws ApiNotFoundException
     */
    public function sendSms(
        UserId $userId,
        SendSmsData $sendSmsData
    ): JsonResponse {
        $user = $this->getRegisteredUser($userId->getValue());

        if (SmsTemplate::REGISTER_USER == $sendSmsData->getSmsTemplate()) {
            $template = new RegisterData($user->getEmail());
        } else {
            $template = new RestoreData($user->getEmail());
        }

        $this->mailerService->sendSmsCode($template);

        return new JsonResponse(
            null,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @param int $id
     *
     * @return User
     */
    private function getRegisteredUser(int $id): User
    {
        try {
            return $this->userRepository->getById($id);
        } catch (EntityNotFoundException $ex) {
            throw new ApiNotFoundException(
                ['user_id' => $ex->getMessage()],
                new ApiErrorCode(ApiErrorCode::ENTITY_NOT_FOUND)
            );
        }
    }
}
