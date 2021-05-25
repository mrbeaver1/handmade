<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class Article
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $author;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private string $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private string $body;

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
     * @var Collection | Comment[]
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private Collection $comments;

    /**
     * @param User                     $author
     * @param string                   $title
     * @param string                   $body
     * @param DateTimeImmutable | null $updatedAt
     * @param DateTimeImmutable | null $deletedAt
     * @param array | Comment[]        $comments
     */
    public function __construct(
        User $author,
        string $title,
        string $body,
        ?DateTimeImmutable $updatedAt,
        ?DateTimeImmutable $deletedAt,
        array $comments = []
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->body = $body;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
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
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
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
    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    /**
     * @return Collection | Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param string $title
     *
     * @return Article
     */
    public function updateTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return Article
     */
    public function updateBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param DateTimeImmutable|null $updatedAt
     *
     * @return Article
     */
    public function updateUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param DateTimeImmutable | null $deletedAt
     *
     * @return Article
     */
    public function updateDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return Article
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
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
            'user' => $this->getAuthor()->getId(),
        ];
    }
}
