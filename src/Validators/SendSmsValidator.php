<?php

namespace App\Validators;

use App\Validation\AbstractValidator;
use App\VO\SmsTemplate;
use Symfony\Component\Validator\Constraints as Assert;

class SendSmsValidator extends AbstractValidator
{
    /**
     * Возвращает список полей с правилами валидации
     *
     * @return array
     */
    protected function getConstraints(): array
    {
        return [
            'smsTemplate' => $this->getSmsTemplateRules(),
        ];
    }

    /**
     * Возвращает список необязательных полей
     *
     * @return array
     */
    protected function getOptionalFields(): array
    {
        return [];
    }

    /**
     * Возвращает правила валидации для шаблона смс
     *
     * @return array
     */
    private function getSmsTemplateRules(): array
    {
        return [
            $this->getNotBlank(),
            new Assert\Choice([
                'value' => SmsTemplate::VALID_VALUES,
                'message' => 'Недопустимое значение шаблона смс',
            ]),
        ];
    }
}
