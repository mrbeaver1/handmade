<?php

namespace App\Validators;

use App\Validation\AbstractValidator;
use Symfony\Component\Validator\Constraints as Assert;

class CheckUserDataValidator extends AbstractValidator
{
    /**
     * Возвращает список полей с правилами валидации
     *
     * @return array
     */
    protected function getConstraints(): array
    {
        return [
            'email' => $this->getEmailRules(),
        ];
    }

    /**
     * Возвращает список необязательных полей
     *
     * @return array
     */
    protected function getOptionalFields(): array
    {
        return [

        ];
    }

    /**
     * Возвращает правила валидации для данных введённых в строку поиска
     *
     * @return array
     */
    private function getEmailRules(): array
    {
        return [
            $this->getNotBlank(),
            new Assert\Email([
                'message' => 'Недопустимое значение e-mail',
            ]),
        ];
    }
}
