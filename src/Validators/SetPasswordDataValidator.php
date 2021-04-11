<?php

namespace App\Validators;

use App\Validation\AbstractValidator;
use Symfony\Component\Validator\Constraints as Assert;

class SetPasswordDataValidator extends AbstractValidator
{
    /**
     * Возвращает список полей с правилами валидации
     *
     * @return array
     */
    protected function getConstraints(): array
    {
        return [
            'password' => $this->getPasswordRules(),
            'password_confirm' => $this->getPasswordRules(),
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

    /**
     * Возвращает правила валидации для данных введённых в строку поиска
     *
     * @return array
     */
    private function getPasswordRules(): array
    {
        return [
            $this->getNotBlank(),
            new Assert\Type([
                'type' => 'string',
            ]),
            new Assert\Regex([
                'pattern' => '/(?=.*[0-9])(?=.*[a-zа-яA-ZА-Я])[0-9a-zа-яA-ZА-Я!@#$%^&*]{6,}/',
                'message' => 'Пароль должен содержать хотя бы одну букву, цифру и быть не менее 6 знаков',
            ]),
        ];
    }
}
