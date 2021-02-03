<?php

namespace App\DTO;

use App\VO\PhoneNumber;

class CheckUserData
{
    /**
     * @var PhoneNumber
     */
    private PhoneNumber $phoneNumber;

    /**
     * @param PhoneNumber $phoneNumber
     */
    public function __construct(PhoneNumber $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return PhoneNumber
     */
    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }
}
