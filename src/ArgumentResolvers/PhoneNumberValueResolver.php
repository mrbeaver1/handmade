<?php

namespace App\ArgumentResolvers;

use App\Exception\ApiHttpException\ApiBadRequestException;
use App\Validators\PhoneNumberValueValidator;
use App\VO\ApiErrorCode;
use App\VO\PhoneNumber;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class PhoneNumberValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var PhoneNumberValueValidator
     */
    private PhoneNumberValueValidator $validator;

    /**
     * @param PhoneNumberValueValidator $validator
     */
    public function __construct(PhoneNumberValueValidator $validator)
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
        return PhoneNumber::class === $argument->getType();
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $params = json_decode($request->getContent(), true);
        $phone = $params['phone'] ?? null;

        $errors = $this->validator->validate([
            'phone' => $phone,
        ]);

        if (!empty($errors)) {
            throw new ApiBadRequestException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        yield new PhoneNumber($phone);
    }
}
