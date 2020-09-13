<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ObjectTransformer;


use App\User\Domain\Model\UserModel;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;

final class UserObjectTransformerFactory
{

    public function toDomain(UserEntity $entity): UserModel
    {
        $userModel = new UserModel();
        $userModel->setName($entity->getName());
        $userModel->setSurname($entity->getSurname());
        $userModel->setEmail($entity->getEmail());
        $userModel->setPassword($entity->getPassword());
        $userModel->setRoles($entity->getRoles());

        return $userModel;
    }

    public function fromDomain(UserModel $model): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->setName($model->getName());
        $userEntity->setSurname($model->getSurname());
        $userEntity->setEmail($model->getEmail());
        $userEntity->setPassword($model->getPassword());
        $userEntity->setRoles($model->getRoles());

        return $userEntity;
    }

}