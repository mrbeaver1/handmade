<?php

namespace App\Validators;

use App\Validation\AbstractValidator;
use Symfony\Component\Validator\Constraints as Assert;

class PhoneNumberValidator extends AbstractValidator
{
    /**
     * Возвращает список полей с правилами валидации
     *
     * @return array
     */
    protected function getConstraints(): array
    {
        return [
            'phone' => $this->getPhoneRules(),
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
     * Возвращает правила валидации для номера телефона
     *
     * @return array
     */
    private function getPhoneRules(): array
    {
        return [
            $this->getNotBlank(),
            new Assert\Regex([
                'pattern' => '/^7\d{10}$/',
                'message' => 'Номер телефона должен состоять из 11 цифр',
            ]),
        ];
    }
}
