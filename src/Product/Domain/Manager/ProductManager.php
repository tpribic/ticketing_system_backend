<?php

declare(strict_types=1);

namespace App\Product\Domain\Manager;


use App\Product\Domain\ContextContract\ProductUserInterface;
use App\Product\Domain\Enum\ProductTypeEnum;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Service\GenerateProductKeysService;
use App\Product\Domain\Storage\ProductStorageInterface;
use App\Product\Infrastructure\Doctrine\Main\Exception\SerialNumberAlreadyExistsException;
use Doctrine\ORM\EntityNotFoundException;
use DomainException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductManager
{

    private ValidatorInterface $validator;
    private ProductStorageInterface $storage;
    private ProductUserInterface $userRepository;
    private GenerateProductKeysService $generateKeyService;

    public function __construct(ValidatorInterface $validator, ProductStorageInterface $storage, ProductUserInterface $userRepository, GenerateProductKeysService $generateKeyService)
    {
        $this->validator = $validator;
        $this->storage = $storage;
        $this->userRepository = $userRepository;
        $this->generateKeyService = $generateKeyService;
    }

    public function save(Product $model): Product
    {
        switch ($model->getProductType()) {
            case ProductTypeEnum::SOFTWARE:
                $model->setSerialNumber($this->generateKeyService->generateSerialNumber());
                $model->setActivationNumber($this->generateKeyService->generateActivationKeyForModel());
                return $model;
            case ProductTypeEnum::HARDWARE:
                if (!$model->getSerialNumber() || !$model->getActivationNumber()) {
                    throw new DomainException("Serial number or activation number not provided for hardware product!");
                }
        }

        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }

        try {
            return $this->storage->save($model);
        } catch (SerialNumberAlreadyExistsException $e) {
            throw new DomainException($e->getMessage());
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
        } catch (EntityNotFoundException $e) {
            throw new DomainException("Product not found");
        }
    }

    public function getUserProducts(string $username)
    {
        $user = $this->userRepository->findOneBy(['email' => $username]);

        return $this->storage->getUserProducts((string)$user->getId());
    }

}