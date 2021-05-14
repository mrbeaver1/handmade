<?php

namespace App\VO;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Embeddable()
 */
class TransactionStatus
{
    /**
     * Новая транзакция
     */
    public const NEW = 'new';

    /**
     * Выплачена
     */
    public const PAID = 'paid';

    /**
     * Отменена
     */
    public const REFUSAL = 'refusal';

    /**
     * Ошибка
     */
    public const PAYMENT_ERROR = 'payment-error';

    /**
     * Допустимые значения статуса транзакции
     */
    private const VALID_VALUES = [
        self::NEW,
        self::PAID,
        self::REFUSAL,
        self::PAYMENT_ERROR,
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
            throw new InvalidArgumentException('Недопустимое значение статуса транзакции');
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
