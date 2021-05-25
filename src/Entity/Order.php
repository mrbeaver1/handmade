<?php

namespace App\Entity;

use App\VO\OrderStatus;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $user;

    /**
     * @var OrderStatus
     *
     * @ORM\Embedded(class="App\Vo\OrderStatus", columnPrefix=false)
     */
    private OrderStatus $status;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable | null
     *
     * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=true)
     */
    private ?DateTimeImmutable $updatedAt;

    /**
     * @var DateTimeImmutable | null
     *
     * @ORM\Column(type="datetime_immutable", name="completed_at", nullable=true)
     */
    private ?DateTimeImmutable $completedAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private int $sum;

    /**
     * @var Shop
     *
     * @ORM\ManyToOne(targetEntity="Shop", inversedBy="orders")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
     */
    private Shop $shop;

    /**
     * @var Collection | Goods[]
     *
     * @ORM\OneToMany(targetEntity="Goods", mappedBy="order")
     */
    private Collection $goods;

    /**
     * @param User                     $user
     * @param OrderStatus              $status
     * @param DateTimeImmutable | null $updatedAt
     * @param DateTimeImmutable | null $completedAt
     * @param int                      $sum
     * @param array | Goods[]          $goods
     */
    public function __construct(
        User $user,
        OrderStatus $status,
        int $sum,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $completedAt = null,
        array $goods = []
    ) {
        $this->user = $user;
        $this->status = $status;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = $updatedAt;
        $this->completedAt = $completedAt;
        $this->sum = $sum;
        $this->goods = new ArrayCollection(array_unique($goods, SORT_REGULAR));
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
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable | null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return DateTimeImmutable | null
     */
    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @return Collection | Goods[]
     */
    public function getGoods(): Collection
    {
        return $this->goods;
    }

    /**
     * @param User $user
     *
     * @return Order
     */
    public function addUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param OrderStatus $status
     *
     * @return Order
     */
    public function updateStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param DateTimeImmutable | null $updatedAt
     *
     * @return Order
     */
    public function updateUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param DateTimeImmutable | null $completedAt
     *
     * @return Order
     */
    public function updateCompletedAt(?DateTimeImmutable $completedAt): self
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    /**
     * @param int $sum
     *
     * @return Order
     */
    public function updateSum(int $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @param Goods $goods
     *
     * @return Order
     */
    public function addGoods(Goods $goods): self
    {
        if (!$this->goods->contains($goods)) {
            $this->goods->add($goods);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
        ];
    }
}
