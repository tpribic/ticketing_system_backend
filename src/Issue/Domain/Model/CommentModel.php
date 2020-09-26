<?php

declare(strict_types=1);

namespace App\Issue\Domain\Model;


use DateTimeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class CommentModel
{
    private ?int $id;
    private string $content;
    private UserInterface $user;
    private int $issue;
    private ?DateTimeInterface $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CommentModel
     */
    public function setId(?int $id): CommentModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return CommentModel
     */
    public function setContent(string $content): CommentModel
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return CommentModel
     */
    public function setUser(UserInterface $user): CommentModel
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getIssue(): int
    {
        return $this->issue;
    }

    /**
     * @param int $issue
     * @return CommentModel
     */
    public function setIssue(int $issue): CommentModel
    {
        $this->issue = $issue;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return CommentModel
     */
    public function setCreatedAt(DateTimeInterface $createdAt): CommentModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}