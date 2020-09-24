<?php

declare(strict_types=1);

namespace App\Product\Application\Resource;


use Symfony\Component\Security\Core\User\UserInterface;

final class ProductResource implements ProductResourceInterface
{
    private string $name;
    private ?string $serialNumber;
    private ?string $activationNumber;
    private int $productType;
    private ?UserInterface $user;
    private bool $isActive;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductResource
    {
        $this->name = $name;
        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): ProductResource
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function getActivationNumber(): ?string
    {
        return $this->activationNumber;
    }

    public function setActivationNumber(?string $activationNumber): ProductResource
    {
        $this->activationNumber = $activationNumber;
        return $this;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function setProductType(int $productType): ProductResource
    {
        $this->productType = $productType;
        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): ProductResource
    {
        $this->user = $user;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): ProductResource
    {
        $this->isActive = $isActive;
        return $this;
    }
}