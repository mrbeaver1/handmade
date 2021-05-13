<?php

namespace App\DTO;

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

    /**
     * @param int    $userId
     * @param string $token
     * @param string $userRole
     */
    public function __construct(int $userId, string $token, string $userRole)
    {
        $this->userId = $userId;
        $this->token = $token;
        $this->userRole = $userRole;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getUserRole(): string
    {
        return $this->userRole;
    }
}
