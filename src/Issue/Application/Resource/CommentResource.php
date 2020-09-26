<?php

declare(strict_types=1);

namespace App\Issue\Application\Resource;


use DateTimeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class CommentResource implements CommentResourceInterface
{
    private ?int $id;
    private string $content;
    private UserInterface $user;
    private int $issue_id;
    private ?DateTimeInterface $date;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CommentResource
     */
    public function setId(?int $id): CommentResource
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
     * @return CommentResource
     */
    public function setContent(string $content): CommentResource
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
     * @return CommentResource
     */
    public function setUser(UserInterface $user): CommentResource
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issue_id;
    }

    /**
     * @param int $issue_id
     * @return CommentResource
     */
    public function setIssueId(int $issue_id): CommentResource
    {
        $this->issue_id = $issue_id;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface|null $date
     * @return CommentResource
     */
    public function setDate(?DateTimeInterface $date): CommentResource
    {
        $this->date = $date;
        return $this;
    }

}