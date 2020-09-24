<?php

declare(strict_types=1);

namespace App\Product\Domain\Manager;


use App\Product\Domain\ContextContract\ProductUserInterface;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Storage\ProductStorageInterface;
use DomainException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductManager
{

    private ValidatorInterface $validator;
    private ProductStorageInterface $storage;
    private ProductUserInterface $userRepository;

    public function __construct(ValidatorInterface $validator, ProductStorageInterface $storage, ProductUserInterface $userRepository)
    {
        $this->validator = $validator;
        $this->storage = $storage;
        $this->userRepository = $userRepository;
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

    public function activateProduct(Product $model, string $username): Product
    {
        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }

        $user = $this->userRepository->findOneBy(['email' => $username]);
        $model->setUser($user);

        try {
            return $this->storage->activateProduct($model);
        } catch (\Exception $e) {
            throw new DomainException("Product not found");
        }
    }

}