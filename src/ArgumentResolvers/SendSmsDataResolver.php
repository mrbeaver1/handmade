<?php

namespace App\ArgumentResolver;

use App\Exception\ApiHttpException\ApiValidationException;
use App\Validation\SendSmsValidator;
use App\VO\ApiErrorCode;
use App\VO\SmsTemplate;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\DTO\SendSmsData;

class SendSmsDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SendSmsValidator
     */
    private SendSmsValidator $validator;

    /**
     * @param SendSmsValidator $validator
     */
    public function __construct(SendSmsValidator $validator)
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
        return SendSmsData::class === $argument->getType();
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
        $params = json_decode($request->getContent(), true);
        $smsTemplate = $params['sms_template'] ?? null;

        $errors = $this->validator->validate([
            'smsTemplate' => $smsTemplate,
        ]);

        if (!empty($errors)) {
            throw new ApiValidationException(
                $errors,
                new ApiErrorCode(ApiErrorCode::VALIDATION_ERROR)
            );
        }

        yield new SendSmsData(new SmsTemplate($smsTemplate));
    }
}
