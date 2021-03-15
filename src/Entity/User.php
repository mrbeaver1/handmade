<?php

namespace App\Entity;

use App\VO\Email;
use App\VO\PhoneNumber;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
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
     * @var PhoneNumber | null
     *
     * @ORM\Column(type="phone_number", name="phone", nullable=true)
     */
    private ?PhoneNumber $phone;

    /**
     * @var Email
     *
     * @Embedded(class="App\VO\Email", columnPrefix=false)
     */
    private Email $email;

    /**
     * @var string | null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $password;

    /**
     * @var Collection | Order[]
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    private Collection $orders;

    /**
     * @var int | null
     */
    private ?int $userId;

    /**
     * @var Collection | Article[]
     *
     * @ORM\OneToMany(targetEntity="Article", mappedBy="user")
     */
    private Collection $articles;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection | Transaction[]
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="user")
     */
    private Collection $transactions;

    /**
     * @var Collection | Card[]
     *
     * @ORM\OneToMany(targetEntity="Card", mappedBy="user")
     */
    private Collection $cards;

    /**
     * @var Collection | Comment[]
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private Collection $comments;

    /**
     * @var Collection | Goods[]
     *
     * @ORM\OneToMany(targetEntity="Goods", mappedBy="user")
     */
    private Collection $goods;

    /**
     * @param Email                 $email
     * @param PhoneNumber | null    $phone
     * @param string | null         $password
     * @param array | Order[]       $orders
     * @param int | null            $userId
     * @param array | Article[]     $articles
     * @param array | Transaction[] $transactions
     * @param array | Card[]        $cards
     * @param array | Comment[]     $comments
     * @param array | Goods[]       $goods
     */
    public function __construct(
        Email $email,
        ?PhoneNumber $phone = null,
        ?string $password = null,
        array $orders = [],
        ?int $userId = null,
        array $articles = [],
        array $transactions = [],
        array $cards = [],
        array $comments = [],
        array $goods = []
    ) {
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->orders = new ArrayCollection(array_unique($orders, SORT_REGULAR));
        $this->userId = $userId;
        $this->articles = new ArrayCollection(array_unique($articles, SORT_REGULAR));
        $this->createdAt = new DateTimeImmutable();
        $this->transactions = new ArrayCollection(array_unique($transactions, SORT_REGULAR));
        $this->cards = new ArrayCollection(array_unique($cards, SORT_REGULAR));
        $this->comments = new ArrayCollection(array_unique($comments, SORT_REGULAR));
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
     * @return PhoneNumber | null
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Collection | Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @return int | null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return Collection | Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection | Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @return Collection | Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    /**
     * @return Collection | Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return string | null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param PhoneNumber $phone
     *
     * @return User
     */
    public function updatePhone(PhoneNumber $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param Email $email
     *
     * @return User
     */
    public function updateEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string | null $password
     *
     * @return User
     */
    public function updatePassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param int | null $userId
     *
     * @return User
     */
    public function updateUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param Order $order
     *
     * @return User
     */
    public function addSale(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }

        return $this;
    }

    /**
     * @param Article $article
     *
     * @return $this
     */
    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    /**
     * @param Transaction $transaction
     *
     * @return $this
     */
    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
        }

        return $this;
    }

    /**
     * @param Card $card
     *
     * @return $this
     */
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    /**
     * @return Collection | Goods[]
     */
    public function getGoods(): Collection
    {
        return $this->goods;
    }

    /**
     * @param Goods $goods
     *
     * @return $this
     */
    public function addGoods(Goods $goods): self
    {
        if (!$this->comments->contains($goods)) {
            $this->comments->add($goods);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getOrdersInArray(): array
    {
        return $this->getOrders()->map(
            static function (Order $order): array {
                return $order->toArray();
            }
        )->toArray();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail()->getValue(),
            'phone' => is_null($this->getPhone()) ? null : $this->getPhone()->getValue(),
            'orders' => $this->getOrdersInArray(),
            'articles' => $this->getArticles()->map(
                static function (Article $article): array {
                    return $article->toArray();
                }
            )->toArray(),
            'created_at' => $this->getCreatedAt()->format(DateTimeImmutable::ATOM),
            'cards' => $this->getCards()->map(
                static function (Card $card): array {
                    return $card->toArray();
                }
            )->toArray(),
            'comments' => $this->getComments()->map(
                static function (Comment $comment): array {
                    return $comment->toArray();
                }
            )->toArray(),
            'goods' => $this->getGoods()->map(
                static function (Goods $goods): array {
                    return $goods->toArray();
                }
            )->toArray(),
        ];
    }

    public function getRoles()
    {

    }

    public function getSalt()
    {

    }

    public function getUsername()
    {

    }

    public function eraseCredentials()
    {

    }
}
