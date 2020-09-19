<?php

declare(strict_types=1);

namespace App\User\Application\Controller;


use App\User\Application\Factory\UserFactory;
use App\User\Domain\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{

    private UserManager $userManager;
    private UserFactory $userFactory;

    public function __construct(UserManager $userManager, UserFactory $userFactory)
    {
        $this->userManager = $userManager;
        $this->userFactory = $userFactory;
    }

    public function register(Request $request): Response
    {
        $user = $this->userFactory->createUserFromRequest($request);

        $this->userManager->save($user);

        return new Response(null, Response::HTTP_CREATED);
    }
}