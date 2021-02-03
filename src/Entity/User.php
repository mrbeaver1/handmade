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
     * @var PhoneNumber
     *
     * @Embedded(class="App\VO\PhoneNumber", columnPrefix="false")
     */
    private PhoneNumber $phone;

    /**
     * @var Email | null
     *
     * @Embedded(class="App\VO\Email", columnPrefix="false")
     */
    private ?Email $email;

    /**
     * @var string | null
     *
     * @ORM\Column(type="string")
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
     * @param PhoneNumber                $phone
     * @param Email | null               $email
     * @param string | null              $password
     * @param Collection | Order[]       $orders
     * @param int | null                 $userId
     * @param Collection | Article[]     $articles
     * @param Collection | Transaction[] $transactions
     * @param Collection | Card[]        $cards
     * @param Collection | Comment[]     $comments
     */
    public function __construct(
        PhoneNumber $phone,
        ?Email $email = null,
        ?string $password = null,
        array $orders = [],
        ?int $userId = null,
        array $articles = [],
        array $transactions = [],
        array $cards = [],
        array $comments = []
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
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return PhoneNumber
     */
    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    /**
     * @return Email | null
     */
    public function getEmail(): ?Email
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
     * @param Email | null $email
     *
     * @return User
     */
    public function updateEmail(?Email $email): self
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
     * @param DateTimeImmutable $createdAt
     *
     * @return User
     */
    public function updateCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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
