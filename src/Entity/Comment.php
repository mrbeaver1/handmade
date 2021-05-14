<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $owner;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private Article $article;

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
     * @var string
     *
     * @ORM\Column(type="text", length=255)
     */
    private string $text;

    /**
     * @param User                     $owner
     * @param Article                  $article
     * @param DateTimeImmutable | null $updatedAt
     * @param DateTimeImmutable | null $deletedAt
     * @param string                   $text
     */
    public function __construct(
        User $owner,
        Article $article,
        string $text,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        $this->owner = $owner;
        $this->article = $article;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->text = $text;
        $this->createdAt = new DateTimeImmutable();
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
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
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
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param DateTimeImmutable | null $updatedAt
     *
     * @return Comment
     */
    public function updateUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @param DateTimeImmutable | null $deletedAt
     *
     * @return Comment
     */
    public function updateDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return Comment
     */
    public function updateText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getOwner()->getId(),
        ];
    }
}
