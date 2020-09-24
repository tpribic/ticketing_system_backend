<?php

declare(strict_types=1);

namespace App\Product\Application\Resource;


final class ActivateProductResource implements ProductResourceInterface
{
    private string $serialNumber;
    private string $activationNumber;

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     * @return ActivateProductResource
     */
    public function setSerialNumber(string $serialNumber): ActivateProductResource
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivationNumber(): string
    {
        return $this->activationNumber;
    }

    /**
     * @param string $activationNumber
     * @return ActivateProductResource
     */
    public function setActivationNumber(string $activationNumber): ActivateProductResource
    {
        $this->activationNumber = $activationNumber;
        return $this;
    }
}