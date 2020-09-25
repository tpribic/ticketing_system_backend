<?php

declare(strict_types=1);

namespace App\Issue\Application\Resource;


use App\Issue\ContextContract\IssueUserInterface;

final class IssueResource implements IssueResrouceInterface
{
    private string $name;
    private string $description;
    private bool $isSolved;
    private string $serialNumber;
    private int $priority;
    private IssueUserInterface $user;
    private ?IssueUserInterface $employee;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return IssueResource
     */
    public function setName(string $name): IssueResource
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return IssueResource
     */
    public function setDescription(string $description): IssueResource
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
    {
        return $this->isSolved;
    }

    /**
     * @param bool $isSolved
     * @return IssueResource
     */
    public function setIsSolved(bool $isSolved): IssueResource
    {
        $this->isSolved = $isSolved;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     * @return IssueResource
     */
    public function setSerialNumber(string $serialNumber): IssueResource
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return IssueResource
     */
    public function setPriority(int $priority): IssueResource
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return IssueUserInterface
     */
    public function getUser(): IssueUserInterface
    {
        return $this->user;
    }

    /**
     * @param IssueUserInterface $user
     * @return IssueResource
     */
    public function setUser(IssueUserInterface $user): IssueResource
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return IssueUserInterface|null
     */
    public function getEmployee(): ?IssueUserInterface
    {
        return $this->employee;
    }

    /**
     * @param IssueUserInterface|null $employee
     * @return IssueResource
     */
    public function setEmployee(?IssueUserInterface $employee): IssueResource
    {
        $this->employee = $employee;
        return $this;
    }

}