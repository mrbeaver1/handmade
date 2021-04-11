<?php

namespace App\Controller;

use App\DTO\CheckUserData;
use App\DTO\CreateUserData;
use App\DTO\RegisterData;
use App\DTO\RestoreData;
use App\DTO\SendSmsData;
use App\DTO\SetPasswordData;
use App\Entity\User;
use App\Exception\ApiHttpException\ApiBadRequestException;
use App\Exception\ApiHttpException\ApiNotFoundException;
use App\Repository\UserRepositoryInterface;
use App\Services\CodeService;
use App\Services\UserService;
use App\VO\ApiErrorCode;
use App\VO\Email;
use App\VO\PhoneNumber;
use App\VO\SmsCode;
use App\VO\SmsTemplate;
use App\VO\UserId;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var CodeService
     */
    private CodeService $codeService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserService             $userService
     * @param CodeService             $codeService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserService $userService,
        CodeService $codeService
    ) {
        parent::__construct($userRepository);

        $this->userService = $userService;
        $this->codeService = $codeService;
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

        $this->codeService->sendSmsCode($template);

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

    /**
     * @Route("/user/{user_id}/code/{code}", methods={"HEAD"})
     *
     * @param UserId  $userId
     * @param SmsCode $checkSmsData
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function checkSms(
        UserId $userId,
        SmsCode $checkSmsData
    ): JsonResponse {
        $user = $this->getRegisteredUser($userId->getValue());

        $this->validateSmsCode(
            $user->getEmail(),
            $checkSmsData->getValue()
        );

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }

    /**
     * @param Email  $email
     * @param string $code
     *
     * @return void
     *
     * @throws Exception
     * @throws ApiNotFoundException
     */
    private function validateSmsCode(
        Email $email,
        string $code
    ): void {
        if (!$this->codeService->isSmsCodeValid($email, $code)) {
            throw new ApiNotFoundException(
                ['code' => "Для пользователя с email = $email код $code не найден"],
                new ApiErrorCode(ApiErrorCode::WRONG_SMS_CODE)
            );
        }
    }

    /**
     * Проверяет смс код и сетит или обновляет пароль юзеру
     *
     * @Route("/user/{user_id}/code/{code}", methods={"PUT"})
     *
     * @param UserId          $userId
     * @param SetPasswordData $setPasswordData
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function updateUserPassword(
        UserId $userId,
        SetPasswordData $setPasswordData
    ): JsonResponse {
        $user = $this->getRegisteredUser($userId->getValue());
        $email = $user->getEmail();

        $this->validateSmsCode($email, $setPasswordData->getCode());

        $this->userService->restorePassword($email, $setPasswordData->getPassword());

        $this->codeService->deactivateCodeByEmail($email);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
