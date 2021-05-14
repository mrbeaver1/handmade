<?php

namespace App\DTO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Expiration
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $expirationYear;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $expirationMonth;

    /**
     * @param string $expirationYear
     * @param string $expirationMonth
     */
    public function __construct(string $expirationYear, string $expirationMonth)
    {
        $this->expirationYear = $expirationYear;
        $this->expirationMonth = $expirationMonth;
    }

    /**
     * @return string
     */
    public function getExpirationYear(): string
    {
        return $this->expirationYear;
    }

    /**
     * @return string
     */
    public function getExpirationMonth(): string
    {
        return $this->expirationMonth;
    }
}
