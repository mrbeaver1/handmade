<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class PhoneNumber
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="phone", unique=true)
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = preg_replace('/\+|\(|\)|\-|\s/', '', $value);
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
