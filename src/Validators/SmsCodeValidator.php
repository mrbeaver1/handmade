<?php

namespace App\Validators;

use App\Validation\AbstractValidator;
use Symfony\Component\Validator\Constraints as Assert;

class SmsCodeValidator extends AbstractValidator
{
    /**
     * Возвращает список полей с правилами валидации
     *
     * @return array
     */
    protected function getConstraints(): array
    {
        return [
            'code' => $this->getCodeRules(),
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
     * Возвращает правила валидации для данных введённых в строку поиска
     *
     * @return array
     */
    private function getCodeRules(): array
    {
        return [
            new Assert\Regex([
                'pattern' => '/^[0-9]{4}$/',
                'message' => 'Вы пытаетесь ввести недопустимые символы. Введите четырёхзначный код.',
            ]),
        ];
    }
}
