<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\ObjectTransformer;


use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\Doctrine\Main\Entity\Product as ProductEntity;
use App\Product\Infrastructure\Doctrine\Main\Entity\ProductType;
use Doctrine\ORM\EntityManagerInterface;

final class ProductObjectTransformer
{

//    private ProductRepository $productRepository;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
//        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    public function toDomain(ProductEntity $entity): Product
    {
        $product = new Product();
        $product
            ->setName($entity->getName())
            ->setSerialNumber($entity->getSerialNumber())
            ->setActivationNumber($entity->getActivationNumber())
            ->setIsActive($entity->getIsActive())
            ->setProductType($entity->getType()->getId())
            ->setUser($entity->getUser());


        return $product;
    }

    public function fromDomain(Product $model): ProductEntity
    {
        $productEntity = new ProductEntity();
        $productType = $this->em->getReference(ProductType::class, $model->getProductType());
        $productEntity
            ->setName($model->getName())
            ->setSerialNumber($model->getSerialNumber())
            ->setActivationNumber($model->getActivationNumber())
            ->setIsActive($model->isActive())
            ->setType($productType);

        return $productEntity;
    }
}