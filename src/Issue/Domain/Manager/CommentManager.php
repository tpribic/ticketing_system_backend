<?php

declare(strict_types=1);

namespace App\Issue\Domain\Manager;


use App\Issue\Domain\Model\CommentModel;
use App\Issue\Domain\Storage\CommentStorageInterface;
use DomainException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CommentManager
{
    private CommentStorageInterface $storage;
    private ValidatorInterface $validator;

    /**
     * CommentManager constructor.
     * @param CommentStorageInterface $storage
     * @param ValidatorInterface $validator
     */
    public function __construct(CommentStorageInterface $storage, ValidatorInterface $validator)
    {
        $this->storage = $storage;
        $this->validator = $validator;
    }

    public function createComment(CommentModel $model): CommentModel
    {
        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }

        try {
            return $this->storage->save($model);
        } catch (\Exception $e) {
            throw new DomainException($e->getMessage());
        }
    }

    public function getComments(string $issueId): array
    {
        return $this->storage->getCommentsForIssue($issueId);
    }
}