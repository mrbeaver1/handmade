<?php

namespace App\Entity;

use App\DTO\Expiration;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="card")
 */
class Card
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="cards")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $panToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $cardholder;

    /**
     * @var Expiration
     *
     * @ORM\Embedded(class="App\DTO\Expiration", columnPrefix=false)
     */
    private Expiration $expiration;

    /**
     * @param User       $user
     * @param string     $panToken
     * @param string     $cardholder
     * @param Expiration $expiration
     */
    public function __construct(
        User $user,
        string $panToken,
        string $cardholder,
        Expiration $expiration
    ) {
        $this->user = $user;
        $this->panToken = $panToken;
        $this->cardholder = $cardholder;
        $this->expiration = $expiration;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMaskedPan(): string
    {
        return '427613******6981';
    }

    /**
     * @return string
     */
    public function getCardholder(): string
    {
        return $this->cardholder;
    }

    /**
     * @return Expiration
     */
    public function getExpiration(): Expiration
    {
        return $this->expiration;
    }

    /**
     * @param string $panToken
     *
     * @return Card
     */
    public function updatePanToken(string $panToken): self
    {
        $this->panToken = $panToken;

        return $this;
    }

    /**
     * @param string $cardholder
     *
     * @return Card
     */
    public function updateCardholder(string $cardholder): self
    {
        $this->cardholder = $cardholder;

        return $this;
    }

    /**
     * @param Expiration $expiration
     *
     * @return Card
     */
    public function updateExpiration(Expiration $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser()->getId(),
        ];
    }
}
