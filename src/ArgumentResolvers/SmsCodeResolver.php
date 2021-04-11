<?php

namespace App\ArgumentResolvers;

use App\Exception\ApiHttpException\ApiValidationException;
use App\Validators\SmsCodeValidator;
use App\VO\ApiErrorCode;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\VO\SmsCode;

class SmsCodeResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SmsCodeValidator
     */
    private SmsCodeValidator $validator;

    /**
     * @param SmsCodeValidator $validator
     */
    public function __construct(SmsCodeValidator $validator)
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
        return SmsCode::class === $argument->getType();
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

        $errors = $this->validator->validate([
            'code' => $code,
        ]);

        if (!empty($errors)) {
            throw new ApiValidationException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        yield new SmsCode($code);
    }
}
