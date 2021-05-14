<?php

namespace App\Entity;

use App\VO\TransactionStatus;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction")
 */
class Transaction
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="transactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime_immutable", name="created_at")
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private int $sum;

    /**
     * @ORM\OneToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     *
     * @var Order
     */
    private Order $order;

    /**
     * @var TransactionStatus
     *
     * @ORM\Embedded(class="App\VO\TransactionStatus", columnPrefix=false)
     */
    private TransactionStatus $status;

    /**
     * @var DateTimeImmutable | null
     *
     * @ORM\Column(type="datetime_immutable", nullable=true, name="payout_date")
     */
    private ?DateTimeImmutable $payoutDate;

    /**
     * @param User                     $user
     * @param int                      $sum
     * @param Order                    $order
     * @param TransactionStatus        $status
     * @param DateTimeImmutable | null $payoutDate
     */
    public function __construct(
        User $user,
        int $sum,
        Order $order,
        TransactionStatus $status,
        ?DateTimeImmutable $payoutDate
    ) {
        $this->user = $user;
        $this->createdAt = new DateTimeImmutable();
        $this->sum = $sum;
        $this->order = $order;
        $this->status = $status;
        $this->payoutDate = $payoutDate;
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
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable | null
     */
    public function getPayoutDate(): ?DateTimeImmutable
    {
        return $this->payoutDate;
    }

    /**
     * @param User $user
     *
     * @return Transaction
     */
    public function updateUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param int $sum
     *
     * @return Transaction
     */
    public function updateSum(int $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @param Order $order
     *
     * @return Transaction
     */
    public function updateOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param TransactionStatus $status
     *
     * @return Transaction
     */
    public function updateStatus(TransactionStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param DateTimeImmutable | null $payoutDate
     *
     * @return Transaction
     */
    public function updatePayoutDate(?DateTimeImmutable $payoutDate): self
    {
        $this->payoutDate = $payoutDate;

        return $this;
    }
}
