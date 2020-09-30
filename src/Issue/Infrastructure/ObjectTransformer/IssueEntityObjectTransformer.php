<?php

declare(strict_types=1);

namespace App\Issue\Infrastructure\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Issue\Domain\Model\IssueModel;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Issue;

final class IssueEntityObjectTransformer implements ObjectTransformerInterface
{

    public function fromDomain(object $model): object
    {
        $issueEntity = new Issue();
        $issueEntity
            ->setName($model->getName())
            ->setDescription($model->getDescription())
            ->setUser($model->getUser())
            ->setEmployee($model->getEmployee())
            ->setIsSolved($model->isSolved())
            ->setPriority($model->getPriority())
            ->setProduct($model->getProduct());

        return $issueEntity;
    }

    public function toDomain(object $entity): object
    {
        $issueModel = new IssueModel();
        $issueModel
            ->setId((string)$entity->getId())
            ->setName($entity->getName())
            ->setDescription($entity->getDescription())
            ->setUser($entity->getUser())
            ->setEmployee($entity->getEmployee())
            ->setIsSolved($entity->getIsSolved())
            ->setPriority($entity->getPriority())
            ->setProduct($entity->getProduct());

        return $issueModel;
    }
}