<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Embeddable()
 */
class GoodsType
{
    /**
     * Допустимые значения типа товаров
     */
    private const VALID_VALUES = [

    ];

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="type")
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
            throw new InvalidArgumentException('Недопустимое значение типа товаров');
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
