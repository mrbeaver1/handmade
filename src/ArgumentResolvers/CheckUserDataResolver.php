<?php

namespace App\ArgumentResolvers;

use App\Validators\CheckUserDataValidator;
use App\VO\Email;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\DTO\CheckUserData;
use App\Exception\ApiHttpException\ApiBadRequestException;
use App\VO\ApiErrorCode;
use Generator;

class CheckUserDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var CheckUserDataValidator
     */
    private CheckUserDataValidator $validator;

    /**
     * @param CheckUserDataValidator $validator
     */
    public function __construct(CheckUserDataValidator $validator)
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
        return CheckUserData::class === $argument->getType();
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $email = $request->get('email');
        $errors = $this->validator->validate(['email' => $email]);

        if (!empty($errors)) {
            throw new ApiBadRequestException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        yield new CheckUserData(new Email($email));
    }
}
