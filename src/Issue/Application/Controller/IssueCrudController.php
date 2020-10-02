<?php

declare(strict_types=1);

namespace App\Issue\Application\Controller;


use App\Common\Service\TokenDecoderService;
use App\Issue\Application\Factory\IssueResourceFactoryInterface;
use App\Issue\Application\Iterator\IssueResourceList;
use App\Issue\Application\Iterator\IssueResourceListIterator;
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

    public function updateIssue(Request $request): Response
    {
        $resource = $this->resourceFactory->createIssueFromRequest($request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $model = $this->issueManager->updateIssue($model);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $resource = $this->objectTransformer->fromDomain($model);
        $response = json_decode($this->serializer->serialize($resource, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt', 'roles']]));

        return new JsonResponse($response, Response::HTTP_OK);
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

    public function getIssue($id, Request $request): JsonResponse
    {
        $issue = $this->issueManager->getIssue($id);
        $resource = $this->objectTransformer->fromDomain($issue);

        $response = json_decode($this->serializer->serialize($resource, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt', 'roles']]));

        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function getAllIssues(Request $request): JsonResponse
    {
        $productIssues = $this->issueManager->getAllIssues();
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function getSolvedIssues(Request $request): JsonResponse
    {
        $productIssues = $this->issueManager->getSolvedIssues();
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function getSolvedUserIssues(Request $request): JsonResponse
    {
        $decodedToken = $this->tokenService->decodeToken($request);

        $productIssues = $this->issueManager->getUserSolvedIssues($decodedToken['username']);
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }


    public function getAllUserIssues(Request $request): JsonResponse
    {
        $decodedToken = $this->tokenService->decodeToken($request);
        $productIssues = $this->issueManager->getAllUserIssues($decodedToken['username']);
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    public function getAllIssuesForProduct($id, Request $request): JsonResponse
    {
        $productIssues = $this->issueManager->getProductIssues($id);
        $response = $this->createIssuesForProductResponse($productIssues);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @param $issues
     * @param array $response
     * @return array
     */
    private function createIssuesForProductResponse($issues, array $response = []): array
    {

        $issueList = new IssueResourceList();
        foreach ($issues as $productIssue) {
            $issueList->addIssue($this->objectTransformer->fromDomain($productIssue));
        }

        $issueListIterator = new IssueResourceListIterator($issueList);

        while ($issueListIterator->hasNext()) {
            $issueListIterator->getNext();
            $response[] = json_decode($this->serializer->serialize($issueListIterator->getCurrent(), 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt', 'roles']]));
        }
        return $response;
    }

}