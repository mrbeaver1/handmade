<?php


namespace App\DTO;


use App\VO\UserRole;

class DecodedTokenData
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var string
     */
    private string $userRole;

    /**
     * @var string
     */
    private string $email;

    /**
     * @param int    $userId
     * @param string $userRole
     * @param string $email
     */
    public function __construct(int $userId, string $userRole, string $email)
    {
        $this->userId = $userId;
        $this->userRole = $userRole;
        $this->email = $email;
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
    public function getUserRole(): string
    {
        return $this->userRole;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
