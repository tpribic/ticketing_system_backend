<?php

declare(strict_types=1);

namespace App\Issue\Application\Controller;


use App\Issue\Application\Factory\CommentResourceFactory;
use App\Issue\Application\Iterator\CommentResourceIterator;
use App\Issue\Application\Iterator\CommentResourceList;
use App\Issue\Application\ObjectTransformer\CommentObjectTransformer;
use App\Issue\Domain\Manager\CommentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CommentCrudController extends AbstractController
{

    private CommentResourceFactory $resourceFactory;
    private CommentObjectTransformer $objectTransformer;
    private CommentManager $commentManager;
    private SerializerInterface $serializer;

    /**
     * CommentCrudController constructor.
     * @param CommentResourceFactory $resourceFactory
     * @param CommentObjectTransformer $objectTransformer
     * @param CommentManager $commentManager
     * @param SerializerInterface $serializer
     */
    public function __construct(CommentResourceFactory $resourceFactory, CommentObjectTransformer $objectTransformer, CommentManager $commentManager, SerializerInterface $serializer)
    {
        $this->resourceFactory = $resourceFactory;
        $this->objectTransformer = $objectTransformer;
        $this->commentManager = $commentManager;
        $this->serializer = $serializer;
    }

    public function addComment($issueId, Request $request): Response
    {
        $resource = $this->resourceFactory->createCommentResourceFromRequest($issueId, $request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $this->commentManager->createComment($model);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response (null, Response::HTTP_CREATED);
    }

    public function getCommentsForIssue($issueId, Request $request): JsonResponse
    {
        $comments = $this->commentManager->getComments($issueId);

        $response = $this->createCommentsForIssueResponse($comments);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @param $issueComments
     * @param array $response
     * @return array
     */
    private function createCommentsForIssueResponse($issueComments, array $response = []): array
    {
        $commentList = new CommentResourceList();

        foreach ($issueComments as $commentIssue) {
            $commentList->addComment($this->objectTransformer->fromDomain($commentIssue));
        }

        $iterator = new CommentResourceIterator($commentList);

        while ($iterator->hasNext()) {
            $iterator->getNext();
            $response[] = json_decode($this->serializer->serialize($iterator->getCurrent(), 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt']]));
        }
        return $response;
    }
}