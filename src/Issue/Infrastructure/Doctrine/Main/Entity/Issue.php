<?php

namespace  App\Issue\Infrastructure\Doctrine\Main\Entity;

use App\Issue\Infrastracture\Doctrine\Main\Repository\IssueRepository;
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
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $employee_id;

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

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getEmployeeId(): ?User
    {
        return $this->employee_id;
    }

    public function setEmployeeId(?User $employee_id): self
    {
        $this->employee_id = $employee_id;

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
