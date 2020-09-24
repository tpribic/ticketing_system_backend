<?php


namespace App\Product\Application\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Product\Application\Resource\ProductResource;
use App\Product\Domain\Model\Product;

final class ProductResourceObjectTransformer implements ObjectTransformerInterface
{

    public function fromDomain(object $model, string $targetClass): object
    {
        $resource = new ProductResource();

        $resource
            ->setName($model->getName())
            ->setIsActive($model->isActive())
            ->setSerialNumber($model->getSerialNumber())
            ->setActivationNumber($model->getActivationNumber())
            ->setProductType($model->getProductType())
            ->setUser($model->getUser());

        return $resource;

    }

    public function toDomain(object $entity, string $targetClass): object
    {
        $model = new Product();

        $model
            ->setName($entity->getName())
            ->setIsActive($entity->isActive())
            ->setSerialNumber($entity->getSerialNumber())
            ->setActivationNumber($entity->getActivationNumber())
            ->setProductType($entity->getProductType())
            ->setUser($entity->getUser());

        return $model;
    }
}