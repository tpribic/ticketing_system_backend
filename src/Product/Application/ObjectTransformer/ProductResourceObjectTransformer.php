<?php


namespace App\Product\Application\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Product\Application\Resource\ProductResource;
use App\Product\Domain\Model\Product;

final class ProductResourceObjectTransformer implements ObjectTransformerInterface
{

    public function fromDomain(object $model): object
    {
        $resource = new ProductResource();

        $resource
            ->setId($model->getId())
            ->setName($model->getName())
            ->setIsActive($model->isActive())
            ->setSerialNumber($model->getSerialNumber())
            ->setActivationNumber($model->getActivationNumber())
            ->setProductType($model->getProductType())
            ->setUser($model->getUser());

        return $resource;
    }

    public function toDomain(object $resource): object
    {
        $model = new Product();

        $model
            ->setName($resource->getName())
            ->setIsActive($resource->isActive())
            ->setSerialNumber($resource->getSerialNumber())
            ->setActivationNumber($resource->getActivationNumber())
            ->setProductType($resource->getProductType())
            ->setUser($resource->getUser());

        return $model;
    }
}