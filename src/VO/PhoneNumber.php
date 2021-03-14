<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class PhoneNumber
{
    /**
     * @var string | null
     *
     * @ORM\Column(type="string", name="phone", nullable=true)
     */
    private $value;

    /**
     * @param string | null $value
     */
    public function __construct(?string $value)
    {
        $this->value = preg_replace('/\+|\(|\)|\-|\s/', '', $value);
    }

    /**
     * @return string
     */
    public function getValue(): ?string
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
