<?php

namespace App\ArgumentResolvers;

use App\DTO\SetPasswordData;
use App\Exception\ApiHttpException\ApiValidationException;
use App\Validators\SetPasswordDataValidator;
use App\VO\ApiErrorCode;
use App\VO\Password;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SetPasswordDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SetPasswordDataValidator
     */
    private SetPasswordDataValidator $validator;

    /**
     * @param SetPasswordDataValidator $validator
     */
    public function __construct(SetPasswordDataValidator $validator)
    {
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
        return SetPasswordData::class === $argument->getType();
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
        $code = $request->get('code');

        $params = json_decode($request->getContent(), true);
        $pass = $params['password'] ?? null;
        $confirmPassword = $params['password_confirm'] ?? null;

        $errors = $this->validator->validate([
            'code' => $code,
            'password' => $pass,
            'password_confirm' => $confirmPassword,
        ]);

        if (!empty($errors)) {
            throw new ApiValidationException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        $password = new Password($pass);

        if (!$password->compare($confirmPassword)) {
            throw new ApiValidationException(
                ['password' => 'Введенные пароли не совпадают'],
                new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR)
            );
        }

        yield new SetPasswordData($code, $password);
    }
}
