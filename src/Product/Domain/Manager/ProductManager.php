<?php

declare(strict_types=1);

namespace App\Product\Domain\Manager;


use App\Product\Domain\Model\Product;
use App\Product\Domain\Storage\ProductStorageInterface;
use DomainException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductManager
{

    private ValidatorInterface $validator;
    private ProductStorageInterface $storage;

    public function __construct(ValidatorInterface $validator, ProductStorageInterface $storage)
    {
        $this->validator = $validator;
        $this->storage = $storage;
    }

    public function save(Product $model): Product
    {
        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }

        try {
            return $this->storage->save($model);
        } catch (\Exception $e) {
            // implement exceptions
        }
    }

}