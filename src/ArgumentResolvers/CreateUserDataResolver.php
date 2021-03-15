<?php

namespace App\ArgumentResolvers;

use App\DTO\CreateUserData;
use App\Exception\ApiHttpException\ApiBadRequestException;
use App\Validators\CreateUserDataValidator;
use App\VO\ApiErrorCode;
use App\VO\Email;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CreateUserDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var CreateUserDataValidator
     */
    private CreateUserDataValidator $validator;

    /**
     * @param CreateUserDataValidator $validator
     */
    public function __construct(CreateUserDataValidator $validator)
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
        return CreateUserData::class === $argument->getType();
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
        $email = $params['email'] ?? null;

        $errors = $this->validator->validate(['email' => $email]);

        if (!empty($errors)) {
            throw new ApiBadRequestException(
                $errors,
                new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR)
            );
        }

        yield new CreateUserData(new Email($email));
    }
}
