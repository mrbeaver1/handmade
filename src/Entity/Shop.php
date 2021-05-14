<?php

namespace App\Entity;

use App\DTO\Address;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="shop")
 */
class Shop
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
     * @var Collection | Goods[]
     *
     * @ORM\OneToMany(targetEntity="Goods", mappedBy="shop")
     */
    private Collection $goods;

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
     * @ORM\Column(type="datetime_immutable", name="deleted_at", nullable=true)
     */
    private ?DateTimeImmutable $deletedAt;

    /**
     * @var Address
     *
     * @ORM\Embedded(class="App\DTO\Address", columnPrefix=false)
     */
    private Address $address;

    /**
     * @var Collection | Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="shop")
     */
    private Collection $orders;

    /**
     *
     * @param array | Goods[]          $goods
     * @param DateTimeImmutable | null $updatedAt
     * @param DateTimeImmutable | null $deletedAt
     * @param Address                  $address
     * @param array | Order[]          $orders
     */
    public function __construct(
        Address $address,
        array $orders = [],
        array $goods = [],
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        $this->goods = new ArrayCollection(array_unique($goods, SORT_REGULAR));
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->address = $address;
        $this->orders = new ArrayCollection(array_unique($orders, SORT_REGULAR));
        $this->createdAt = new DateTimeImmutable();
    }
}
