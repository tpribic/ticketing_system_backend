<?php

declare(strict_types=1);

namespace App\User\Application\Factory;


use App\User\Application\Exception\RequestInvalidException;
use App\User\Domain\Model\UserModel;
use Symfony\Component\HttpFoundation\Request;

class UserFactory
{

    public function createUserFromRequest(Request $request): UserModel
    {
        $userModel = new UserModel();

        switch ($request->get('role')){
            case null:
                $userModel->setRoles(['role' => 'USER']);
                break;
            case 'ADMIN':
                $userModel->setRoles(['role' => 'ADMIN']);
                break;
            case 'EMPLOYEE':
                $userModel->setRoles(['role' => 'EMPLOYEE']);
        }

        try{
            $userModel->setEmail($request->get('email'));
            $userModel->setPassword($request->get('password'));
            $userModel->setName($request->get('name'));
            $userModel->setSurname($request->get('surname'));
        } catch (RequestInvalidException $exception)
        {
        }

    return $userModel;

    }
}