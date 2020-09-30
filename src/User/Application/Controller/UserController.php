<?php

declare(strict_types=1);

namespace App\User\Application\Controller;


use App\User\Application\Exception\RequestInvalidException;
use App\User\Application\Factory\UserFactory;
use App\User\Domain\Manager\UserManager;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    private UserManager $userManager;
    private UserFactory $userFactory;
    private SerializerInterface $serializer;

    public function __construct(UserManager $userManager, UserFactory $userFactory, SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->userFactory = $userFactory;
        $this->serializer = $serializer;
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

    public function getAllEmployees(Request $request): JsonResponse
    {
        $employees = $this->userManager->getAllEmployees();

        $response = $this->createUsersResponse($employees);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    private function createUsersResponse($users, array $response = []): array
    {
        foreach ($users as $user) {
            $response[] = json_decode($this->serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt', 'roles']]));
        }
        return $response;
    }
}