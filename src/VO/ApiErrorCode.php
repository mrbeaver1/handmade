<?php

namespace App\VO;

use InvalidArgumentException;

class ApiErrorCode
{
    /**
     * Пользователь не найден
     */
    public const USER_NOT_FOUND = 'user-not-found';

    /**
     * Дом не найден
     */
    public const BUILD_NOT_FOUND = 'build-not-found';

    /**
     * Квартира не найдена
     */
    public const FLAT_NOT_FOUND = 'flat-not-found';

    /**
     * Неверно указано/не указано поле/несколько полей
     */
    public const USER_VALIDATION_ERROR = 'user-validation-error';

    /**
     * Неверно указано/не указано поле/несколько полей
     */
    public const VALIDATION_ERROR = 'validation-error';

    /**
     * Клиент существует
     */
    public const USER_NOT_UNIQUE = 'user-not-unique';

    /**
     * Сущность уже существует
     */
    public const ENTITY_EXISTS = 'entity-exists';

    /**
     * Сущность не найдена
     */
    public const ENTITY_NOT_FOUND = 'entity-not-found';

    /**
     * Квартира не принадлежит пользователю
     */
    public const FLAT_NOT_BELONGS_TO_USER = 'flat-not-belongs-to-user';

    /**
     * Ошибка апи ВсегдаДа
     */
    public const VSEGDA_DA_API_ERROR = 'vsegda-da-api-error';

    /**
     * Неверный смс-код
     */
    public const WRONG_SMS_CODE = 'wrong-sms-code';

    /**
     * Неверный пароль
     */
    public const WRONG_PASSWORD = 'wrong-password';

    /**
     * Исключение, выброшенное AuthProdavayApi
     */
    public const AUTH_PRODAVAY_API_EXCEPTION = 'auth-prodavay-api-exception';

    /**
     * Не передан токен
     */
    public const AUTHENTICATION_TOKEN_ABSENCE = 'authentification-token-absence';

    /**
     * Неверный токен
     */
    public const WRONG_TOKEN = 'wrong-token';

    /**
     * Ошибка валидации токена
     */
    public const TOKEN_VALIDATION_ERROR = 'token-validation-error';

    /**
     * Ошибка apiBadRequest
     */
    public const BAD_REQUEST_ERROR = 'bad-request-error';

    /**
     * Ошибка bikInfoApi
     */
    public const BIK_INFO_API_ERROR = 'bik-info-api-error';

    /**
     * Ошибка валидации bik
     */
    public const BIK_VALIDATION_ERROR = 'bik-validation-error';

    /**
     * Допустимые значения кода ошибки
     */
    private const VALID_VALUES = [
        self::USER_NOT_UNIQUE,
        self::USER_NOT_FOUND,
        self::BUILD_NOT_FOUND,
        self::FLAT_NOT_FOUND,
        self::USER_VALIDATION_ERROR,
        self::USER_VALIDATION_ERROR,
        self::VALIDATION_ERROR,
        self::ENTITY_EXISTS,
        self::ENTITY_NOT_FOUND,
        self::VSEGDA_DA_API_ERROR,
        self::WRONG_SMS_CODE,
        self::WRONG_PASSWORD,
        self::AUTH_PRODAVAY_API_EXCEPTION,
        self::AUTHENTICATION_TOKEN_ABSENCE,
        self::WRONG_TOKEN,
        self::TOKEN_VALIDATION_ERROR,
        self::BAD_REQUEST_ERROR,
        self::FLAT_NOT_BELONGS_TO_USER,
        self::BIK_INFO_API_ERROR,
        self::BIK_VALIDATION_ERROR,
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
            throw new InvalidArgumentException("Недопустимое значение кода ошибки $value");
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
