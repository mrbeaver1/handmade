<?php

namespace App\Entity;

use App\VO\GoodsStatus;
use App\VO\GoodsType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="goods")
 */
class Goods
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
     * @var Shop
     *
     * @ORM\ManyToOne(targetEntity="Shop", mappedBy="goods")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
     */
    private Shop $shop;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private int $cost;

    /**
     * @var GoodsType
     *
     * @ORM\Embedded(class="App\VO\GoodsType", columnPrefix=false)
     */
    private GoodsType $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @var GoodsStatus
     *
     * @ORM\Embedded(class="App\VO\GoodsStatus", columnPrefix=false)
     */
    private GoodsStatus $status;

    /**
     * @var Order | null
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="goods")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true")
     */
    private ?Order $order;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $colors;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $structure;

    /**
     * @param Shop          $shop
     * @param int           $cost
     * @param GoodsType     $type
     * @param string        $name
     * @param GoodsStatus   $status
     * @param Order | null  $order
     * @param int           $quantity
     * @param string        $colors
     * @param string        $description
     * @param string        $structure
     */
    public function __construct(
        Shop $shop,
        int $cost,
        GoodsType $type,
        string $name,
        GoodsStatus $status,
        ?Order $order,
        int $quantity,
        string $colors,
        string $description,
        string $structure
    ) {
        $this->shop = $shop;
        $this->cost = $cost;
        $this->type = $type;
        $this->name = $name;
        $this->status = $status;
        $this->order = $order;
        $this->quantity = $quantity;
        $this->colors = $colors;
        $this->description = $description;
        $this->structure = $structure;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Shop
     */
    public function getShop(): Shop
    {
        return $this->shop;
    }

    /**
     * @return int
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * @return GoodsType
     */
    public function getType(): GoodsType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return GoodsStatus
     */
    public function getStatus(): GoodsStatus
    {
        return $this->status;
    }

    /**
     * @return Order | null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getColors(): string
    {
        return $this->colors;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStructure(): string
    {
        return $this->structure;
    }

    /**
     * @param int $cost
     *
     * @return Goods
     */
    public function updateCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @param GoodsType $type
     *
     * @return Goods
     */
    public function updateType(GoodsType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Goods
     */
    public function updateName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param GoodsStatus $status
     *
     * @return Goods
     */
    public function updateStatus(GoodsStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return Goods
     */
    public function updateQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param string $colors
     *
     * @return Goods
     */
    public function updateColors(string $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $structure
     */
    public function setStructure(string $structure): void
    {
        $this->structure = $structure;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }
}
