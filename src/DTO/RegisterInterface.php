<?php

namespace App\DTO;

use App\VO\Email;

interface RegisterInterface
{
    /**
     * @return Email
     */
    public function getEmail(): Email;
}
