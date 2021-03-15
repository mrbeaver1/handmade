<?php

namespace App\VO;

use InvalidArgumentException;

/**
 * Тип шаблона смс
 */
class SmsTemplate
{
    /**
     * Шаблон для регистрации пользователя
     */
    public const REGISTER_USER = 'register';

    /**
     * Шаблон для восстановления пароля
     */
    public const RESTORE_USER_PASSWORD = 'restore';

    /**
     * Допустимые значения
     */
    public const VALID_VALUES = [
        self::REGISTER_USER,
        self::RESTORE_USER_PASSWORD,
    ];

    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, self::VALID_VALUES)) {
            throw new InvalidArgumentException("Недопустимое значение шаблона смс кода: $value");
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
