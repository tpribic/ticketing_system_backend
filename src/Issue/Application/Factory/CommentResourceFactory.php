<?php

declare(strict_types=1);

namespace App\Issue\Application\Factory;


use App\Common\Service\TokenDecoderService;
use App\Issue\Application\Resource\CommentResource;
use App\Issue\Application\Resource\CommentResourceInterface;
use App\Issue\ContextContract\CommentUserInterface;
use Symfony\Component\HttpFoundation\Request;

class CommentResourceFactory
{

    private TokenDecoderService $tokenService;
    private CommentUserInterface $userStorage;

    /**
     * CommentResourceFactory constructor.
     * @param TokenDecoderService $tokenService
     * @param CommentUserInterface $userStorage
     */
    public function __construct(TokenDecoderService $tokenService, CommentUserInterface $userStorage)
    {
        $this->tokenService = $tokenService;
        $this->userStorage = $userStorage;
    }

    public function createCommentResourceFromRequest($id, Request $request): CommentResourceInterface
    {
        $decodedToken = $this->tokenService->decodeToken($request);
        $user = $this->userStorage->findOneBy(['email' => $decodedToken['username']]);

        $commentResource = new CommentResource();

        $commentResource
            ->setId(null)
            ->setIssueId((int)$id)
            ->setContent($request->get('content'))
            ->setUser($user);

        if ($request->get('commentId')) {
            $commentResource->setId($request->get('commentId'));
        }
        return $commentResource;
    }

}