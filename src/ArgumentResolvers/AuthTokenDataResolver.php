<?php

namespace App\ArgumentResolvers;

use App\DTO\AuthTokenData;
use App\Exception\ApiHttpException\ApiUnauthorizedException;
use App\Exception\ApiHttpException\ApiValidationException;
use App\Services\AuthServiceApi\AuthServiceApi;
use App\Validators\AuthTokenDataValidator;
use App\VO\ApiErrorCode;
use Exception;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class AuthTokenDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var AuthServiceApi
     */
    private AuthServiceApi $authService;

    /**
     * @var AuthTokenDataValidator
     */
    private AuthTokenDataValidator $validator;

    /**
     * @param AuthServiceApi         $authService
     * @param AuthTokenDataValidator $validator
     */
    public function __construct(AuthServiceApi $authService, AuthTokenDataValidator $validator)
    {
        $this->authService = $authService;
        $this->validator = $validator;
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return AuthTokenData::class === $argument->getType();
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     *
     * @throws ApiValidationException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $token = $request->headers->get('Authorization');

        if (empty($token)) {
            throw new ApiUnauthorizedException(
                ['token' => 'Поле обязательно к заполнению'],
                new ApiErrorCode(ApiErrorCode::AUTHENTICATION_TOKEN_ABSENCE)
            );
        }

        if (!preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            throw new ApiUnauthorizedException(
                ['Пользователь не авторизован. Неверный токен.'],
                new ApiErrorCode(ApiErrorCode::WRONG_TOKEN)
            );
        }

        $tokenValue = $matches[1];
        $id = $request->get('user_id');

        $errors = $this->validator->validate([
            'user_d' => $id,
            'token' => $tokenValue,
        ]);

        if (!empty($errors)) {
            throw new ApiValidationException($errors, new ApiErrorCode(ApiErrorCode::TOKEN_VALIDATION_ERROR));
        }

        try {
            $tokenData = $this->authService->decodeToken($tokenValue);
        } catch (Exception $exception){
            throw new ApiUnauthorizedException(
                ['Пользователь не авторизован. Неверный токен.'],
                new ApiErrorCode(ApiErrorCode::WRONG_TOKEN)
            );
        }

        if (!empty($id)) {
            if ($tokenData->getUserId() != $id) {
                throw new ApiUnauthorizedException(
                    ['Пользователь не авторизован. Неверный токен.'],
                    new ApiErrorCode(ApiErrorCode::WRONG_TOKEN)
                );
            }
        }

        yield new AuthTokenData($tokenData->getUserId(), $token, $tokenData->getUserRole());
    }
}
