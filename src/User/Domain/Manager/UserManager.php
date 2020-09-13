<?php

declare(strict_types=1);

namespace App\User\Domain\Manager;


use App\User\Domain\Model\UserModel;
use App\User\Domain\Storage\UserStorageInterface;

class UserManager
{
    private UserStorageInterface $userStorage;

    public function __construct(UserStorageInterface $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    public function save(UserModel $model): UserModel
    {
        //validacije

        return $this->userStorage->save($model);
    }


}