<?php

namespace App\ArgumentResolvers;

use App\Validators\UserIdValidator;
use App\VO\UserId;
use App\Exception\ApiHttpException\ApiNotFoundException;
use App\VO\ApiErrorCode;
use Exception;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class UserIdResolver implements ArgumentValueResolverInterface
{
    /**
     * @var UserIdValidator
     */
    private UserIdValidator $validator;

    /**
     * @param UserIdValidator $validator
     */
    public function __construct(UserIdValidator $validator)
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
        return UserId::class === $argument->getType();
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     *
     * @throws Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        $userId = $request->get('user_id');

        $errors = $this->validator->validate(['userId' => $userId]);

        if (!empty($errors)) {
            throw new ApiNotFoundException($errors, new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR));
        }

        yield new UserId($userId);
    }
}
