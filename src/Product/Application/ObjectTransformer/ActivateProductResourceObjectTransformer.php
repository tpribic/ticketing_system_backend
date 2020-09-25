<?php

declare(strict_types=1);

namespace App\Product\Application\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Product\Application\Resource\ProductResource;
use App\Product\Domain\Model\Product;

final class ActivateProductResourceObjectTransformer implements ObjectTransformerInterface
{
    public function fromDomain(object $model): object
    {
        $resource = new ProductResource();

        $resource
            ->setSerialNumber($model->getSerialNumber())
            ->setActivationNumber($model->getActivationNumber());

        return $resource;

    }

    public function toDomain(object $entity): object
    {
        $model = new Product();

        $model
            ->setSerialNumber($entity->getSerialNumber())
            ->setActivationNumber($entity->getActivationNumber());

        return $model;
    }
}