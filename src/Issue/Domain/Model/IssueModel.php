<?php

declare(strict_types=1);

namespace App\Issue\Domain\Model;


use App\Issue\ContextContract\IssueUserInterface as UserInterface;
use App\Issue\ContextContract\IssueProductInterface as ProductInterface;
use App\Issue\ContextContract\PriorityInterface;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Priority;


final class IssueModel
{
    private ?string $id;
    private string $name;
    private string $description;
    private bool $isSolved;
    private UserInterface $user;
    private ?UserInterface $employee;
    private ProductInterface $product;
    private Priority $priority;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return IssueModel
     */
    public function setId(string $id): IssueModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return IssueModel
     */
    public function setName(string $name): IssueModel
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
     * @return IssueModel
     */
    public function setDescription(string $description): IssueModel
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
     * @return IssueModel
     */
    public function setIsSolved(bool $isSolved): IssueModel
    {
        $this->isSolved = $isSolved;
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
     * @return IssueModel
     */
    public function setUser(UserInterface $user): IssueModel
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getEmployee(): ?UserInterface
    {
        return $this->employee;
    }

    /**
     * @param UserInterface|null $employee
     * @return IssueModel
     */
    public function setEmployee(?UserInterface $employee): IssueModel
    {
        $this->employee = $employee;
        return $this;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @param ProductInterface $product
     * @return IssueModel
     */
    public function setProduct(ProductInterface $product): IssueModel
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return PriorityInterface
     */
    public function getPriority(): PriorityInterface
    {
        return $this->priority;
    }

    /**
     * @param PriorityInterface $priority
     * @return IssueModel
     */
    public function setPriority(PriorityInterface $priority): IssueModel
    {
        $this->priority = $priority;
        return $this;
    }

}