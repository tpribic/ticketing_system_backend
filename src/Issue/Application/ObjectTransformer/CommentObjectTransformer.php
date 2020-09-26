<?php

declare(strict_types=1);

namespace App\Issue\Application\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Issue\Application\Resource\CommentResource;
use App\Issue\Domain\Model\CommentModel;

final class CommentObjectTransformer implements ObjectTransformerInterface
{
    public function fromDomain(object $model): object
    {
        $resource = new CommentResource();
        $resource
            ->setId($model->getId())
            ->setContent($model->getContent())
            ->setDate($model->getCreatedAt())
            ->setIssueId($model->getIssue())
            ->setUser($model->getUser());

        return $resource;
    }

    public function toDomain(object $resource): object
    {
        $domainModel = new CommentModel();
        $domainModel
            ->setId($resource->getId())
            ->setUser($resource->getUser())
            ->setContent($resource->getContent())
            ->setIssue($resource->getIssueId());

        return $domainModel;
    }
}