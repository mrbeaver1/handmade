<?php

namespace App\Entity;

use App\VO\Email;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="code")
 */
class Code
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @var Email
     *
     * @ORM\Column(type="email")
     */
    private Email $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $code;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="is_active")
     */
    protected bool $isActive;

    /**
     * @param Email             $email
     * @param string            $code
     * @param DateTimeImmutable $createdAt
     * @param bool              $isActive
     */
    public function __construct(
        Email $email,
        string $code,
        DateTimeImmutable $createdAt,
        bool $isActive = true
    ) {
        $this->email = $email;
        $this->code = $code;
        $this->createdAt = $createdAt;
        $this->isActive = $isActive;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return self
     */
    public function activate(): self
    {
        $this->isActive = true;

        return $this;
    }

    /**
     * @return self
     */
    public function deactivate(): self
    {
        $this->isActive = false;

        return $this;
    }
}
