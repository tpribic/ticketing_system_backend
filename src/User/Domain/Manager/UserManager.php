<?php

declare(strict_types=1);

namespace App\User\Domain\Manager;


use App\User\Domain\Model\UserModel;
use App\User\Domain\ObjectTransformer\UserObjectTransformerFactory;
use App\User\Domain\Storage\UserStorageInterface;
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

        //validacije

        return $this->userStorage->save($model);
    }


}