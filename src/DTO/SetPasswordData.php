<?php

namespace App\DTO;

use App\VO\Password;

class SetPasswordData
{
    /**
     * @var string
     */
    private string $code;

    /**
     * @var Password
     */
    private Password $password;

    /**
     * @param string   $code
     * @param Password $password
     */
    public function __construct(
        string $code,
        Password $password
    ) {
        $this->code = $code;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }
}
