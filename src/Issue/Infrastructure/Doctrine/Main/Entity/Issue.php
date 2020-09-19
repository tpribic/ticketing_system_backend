<?php

namespace  App\Issue\Infrastructure\Doctrine\Main\Entity;

use App\Issue\Infrastructure\Doctrine\Main\Repository\IssueRepository;
use App\Product\Infrastructure\Doctrine\Main\Entity\Product;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IssueRepository::class)
 */
final class Issue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSolved;

    /**
     * @ORM\ManyToOne(targetEntity=IssueType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_id;

    /**
     * @ORM\ManyToOne(targetEntity=UserEntity::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=UserEntity::class)
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity=Priority::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $priority_id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="issue_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsSolved(): ?bool
    {
        return $this->isSolved;
    }

    public function setIsSolved(bool $isSolved): self
    {
        $this->isSolved = $isSolved;

        return $this;
    }

    public function getTypeId(): ?IssueType
    {
        return $this->type_id;
    }

    public function setTypeId(?IssueType $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEmployee(): ?UserEntity
    {
        return $this->employee;
    }

    public function setEmployee(?UserEntity $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getPriorityId(): ?Priority
    {
        return $this->priority_id;
    }

    public function setPriorityId(?Priority $priority_id): self
    {
        $this->priority_id = $priority_id;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }
}
