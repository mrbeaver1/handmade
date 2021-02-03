<?php

namespace App\ArgumentResolvers;

use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\DTO\CheckUserData;
use App\Exceptions\ApiHttpException\ApiBadRequestException;
use App\VO\ApiErrorCode;
use App\VO\PhoneNumber;
use App\Validators\PhoneNumberValidator;
use Generator;

class CheckUserDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var PhoneNumberValidator
     */
    private PhoneNumberValidator $validator;

    /**
     * @param PhoneNumberValidator $validator
     */
    public function __construct(PhoneNumberValidator $validator)
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
        $phone = $request->get('phone');
        $errors = $this->validator->validate(['phone' => $phone]);

        if (!empty($errors)) {
            throw new ApiBadRequestException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        yield new CheckUserData(new PhoneNumber($phone));
    }
}
