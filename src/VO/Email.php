<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="email", unique=true)
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
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
