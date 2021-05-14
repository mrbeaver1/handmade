<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Embeddable()
 */
class OrderStatus
{
    /**
     * Новый заказ
     */
    public const NEW = 'new';

    /**
     * Оплачен
     */
    public const PAID = 'paid';

    /**
     * Готов
     */
    public const READY = 'ready';

    /**
     * Получен
     */
    public const COMPLETED = 'completed';

    /**
     * Отменен
     */
    public const REFUSAL = 'refusal';

    /**
     * Допустимые значения статуса заказа
     */
    private const VALID_VALUES = [
        self::NEW,
        self::PAID,
        self::READY,
        self::COMPLETED,
        self::REFUSAL,
    ];

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="status")
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
            throw new InvalidArgumentException('Недопустимое значение статуса заказа');
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
