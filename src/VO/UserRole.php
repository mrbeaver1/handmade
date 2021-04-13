<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Embeddable()
 */
class UserRole
{
    /**
     * Пользователь
     */
    public const USER = 'user';

    /**
     * Админ
     */
    public const ADMIN = 'admin';

    /**
     * Менеджер магазина
     */
    public const SCORE_MANAGER = 'score-manager';

    /**
     * Допустимые значения кода ошибки
     */
    private const VALID_VALUES = [
        self::USER,
        self::ADMIN,
        self::SCORE_MANAGER,
    ];

    /**
     * @ORM\Column(type="string", name="role", nullable=true)
     *
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
            throw new InvalidArgumentException('Недопустимое значение роли юзера');
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