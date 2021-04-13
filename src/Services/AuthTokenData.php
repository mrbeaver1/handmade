<?php

namespace App\Services;

class AuthTokenData
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var string
     */
    private string $userRole;
}