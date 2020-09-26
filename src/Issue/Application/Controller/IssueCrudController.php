<?php

declare(strict_types=1);

namespace App\Issue\Application\Controller;


use App\Common\Service\TokenDecoderService;
use App\Issue\Application\Factory\IssueResourceFactoryInterface;
use App\Issue\Application\ObjectTransformer\IssueObjectTransformer;
use App\Issue\Domain\Manager\IssueManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class IssueCrudController extends AbstractController
{

    private IssueManager $issueManager;
    private IssueResourceFactoryInterface $resourceFactory;
    private IssueObjectTransformer $objectTransformer;
    private TokenDecoderService $tokenService;
    private SerializerInterface $serializer;

    /**
     * IssueCrudController constructor.
     * @param IssueManager $issueManager
     * @param TokenDecoderService $tokenService
     * @param IssueResourceFactoryInterface $resourceFactory
     * @param IssueObjectTransformer $objectTransformer
     * @param SerializerInterface $serializer
     */
    public function __construct(IssueManager $issueManager, TokenDecoderService $tokenService, IssueResourceFactoryInterface $resourceFactory, IssueObjectTransformer $objectTransformer, SerializerInterface $serializer)
    {
        $this->issueManager = $issueManager;
        $this->tokenService = $tokenService;
        $this->resourceFactory = $resourceFactory;
        $this->objectTransformer = $objectTransformer;
        $this->serializer = $serializer;
    }

    public function create(Request $request): Response
    {
        $decodedToken = $this->tokenService->decodeToken($request);
        $resource = $this->resourceFactory->createIssueFromRequest($request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $this->issueManager->createIssue($model, $decodedToken['username']);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response (null, Response::HTTP_CREATED);
    }

    public function updateIssueAssignee(Request $request): Response
    {
        $resource = $this->resourceFactory->createIssueFromRequest($request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $this->issueManager->assignEmployeeToIssue($model);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response (null, Response::HTTP_OK);
    }

    public function getAllIssuesForProduct($id, Request $request): JsonResponse
    {
        $productIssues = $this->issueManager->getProductIssues($id);
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @param $productIssues
     * @param array $parsedProductIssues
     * @param array $response
     * @return array
     */
    private function createIssuesForProductResponse($productIssues, array $parsedProductIssues = [], array $response = []): array
    {
        foreach ($productIssues as $productIssue) {
            $parsedProductIssues[] = $this->objectTransformer->fromDomain($productIssue);
        }

        foreach ($parsedProductIssues as $parsed) {
            $response[] = json_decode($this->serializer->serialize($parsed, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'name', 'surname', 'salt', 'roles']]));
        }
        return $response;
    }

}