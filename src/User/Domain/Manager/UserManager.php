<?php

declare(strict_types=1);

namespace App\User\Domain\Manager;


use App\User\Domain\Exception\DomainModelException;
use App\User\Domain\Model\UserModel;
use App\User\Domain\ObjectTransformer\UserObjectTransformerFactory;
use App\User\Domain\Storage\UserStorageInterface;
use App\User\Infrastructure\Doctrine\Exception\UserAlreadyExistsException;
use DomainException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private UserStorageInterface $userStorage;
    private ValidatorInterface $validator;

    public function __construct(UserStorageInterface $userStorage, ValidatorInterface $validator)
    {
        $this->userStorage = $userStorage;
        $this->validator = $validator;
    }

    public function save(UserModel $model): UserModel
    {
        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }
        try {
            return $this->userStorage->save($model);
        } catch (UserAlreadyExistsException $e) {
            throw new DomainException("User already exists!");
        }
    }


}