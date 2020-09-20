<?php

declare(strict_types=1);

namespace App\User\Application\Controller;


use App\User\Application\Exception\RequestInvalidException;
use App\User\Application\Factory\UserFactory;
use App\User\Domain\Manager\UserManager;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    private UserManager $userManager;
    private UserFactory $userFactory;
    private ValidatorInterface $validator;

    public function __construct(UserManager $userManager, UserFactory $userFactory, ValidatorInterface $validator)
    {
        $this->userManager = $userManager;
        $this->userFactory = $userFactory;
        $this->validator = $validator;
    }

    public function register(Request $request): Response
    {
        try {
            $user = $this->userFactory->createUserFromRequest($request);
            $this->userManager->save($user);
        } catch (DomainException | RequestInvalidException $e) {
            return new Response($e->getMessage(), Response::HTTP_CONFLICT);
        }

        return new Response(null, Response::HTTP_CREATED);
    }
}