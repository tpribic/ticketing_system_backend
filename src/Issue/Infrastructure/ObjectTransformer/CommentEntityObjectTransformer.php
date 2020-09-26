<?php

declare(strict_types=1);

namespace App\Issue\Infrastructure\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Issue\Domain\Model\CommentModel;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Comment;
use App\Issue\Infrastructure\Doctrine\Main\Repository\IssueRepository;

final class CommentEntityObjectTransformer implements ObjectTransformerInterface
{

    private IssueRepository $issueRepository;

    /**
     * CommentEntityObjectTransformer constructor.
     * @param IssueRepository $issueRepository
     */
    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    public function fromDomain(object $model): object
    {
        $issue = $this->issueRepository->findOneBy(['id' => $model->getIssue()]);

        $entity = new Comment();
        $entity
            ->setIssueId($issue)
            ->setUser($model->getUser())
            ->setContent($model->getContent());

        return $entity;
    }

    public function toDomain(object $entity): object
    {
        $domainModel = new CommentModel();
        $domainModel
            ->setId($entity->getId())
            ->setUser($entity->getUser())
            ->setContent($entity->getContent())
            ->setCreatedAt($entity->getCreatedAt())
            ->setIssue($entity->getIssueId()->getId());

        return $domainModel;
    }
}