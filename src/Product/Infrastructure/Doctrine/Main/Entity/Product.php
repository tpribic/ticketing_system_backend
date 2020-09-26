<?php

namespace App\Product\Infrastructure\Doctrine\Main\Entity;

use App\Issue\ContextContract\IssueProductInterface;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Issue;
use App\Product\Infrastructure\Doctrine\Main\Repository\ProductRepository;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product implements IssueProductInterface
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
     * @ORM\Column(type="string", length=45, unique=true)
     */
    private $serial_number;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $activation_number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=ProductType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_id;

    /**
     * @ORM\OneToMany(targetEntity=Issue::class, mappedBy="product_id")
     */
    private $issue_id;

    /**
     * @ORM\ManyToOne(targetEntity=UserEntity::class)
     */
    private $user;

    public function __construct()
    {
        $this->issue_id = new ArrayCollection();
    }

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

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $serial_number): self
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getActivationNumber(): ?string
    {
        return $this->activation_number;
    }

    public function setActivationNumber(string $activation_number): self
    {
        $this->activation_number = $activation_number;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getType(): ?ProductType
    {
        return $this->type_id;
    }

    public function setType(?ProductType $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * @return Collection|Issue[]
     */
    public function getIssueId(): Collection
    {
        return $this->issue_id;
    }

    public function addIssueId(Issue $issueId): self
    {
        if (!$this->issue_id->contains($issueId)) {
            $this->issue_id[] = $issueId;
            $issueId->setProductId($this);
        }

        return $this;
    }

    public function removeIssueId(Issue $issueId): self
    {
        if ($this->issue_id->contains($issueId)) {
            $this->issue_id->removeElement($issueId);
            // set the owning side to null (unless already changed)
            if ($issueId->getProductId() === $this) {
                $issueId->setProductId(null);
            }
        }

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
}
