<?php

declare(strict_types=1);

namespace App\Product\Domain\Model;


use App\Product\Domain\ContextContract\ProductUserInterface as UserInterface;

final class Product
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

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(?string $serialNumber): Product
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function getActivationNumber(): ?string
    {
        return $this->activationNumber;
    }

    public function setActivationNumber(?string $activationNumber): Product
    {
        $this->activationNumber = $activationNumber;
        return $this;
    }

    public function getProductType(): int
    {
        return $this->productType;
    }

    public function setProductType(int $productType): Product
    {
        $this->productType = $productType;
        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): Product
    {
        $this->user = $user;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): Product
    {
        $this->isActive = $isActive;
        return $this;
    }
}