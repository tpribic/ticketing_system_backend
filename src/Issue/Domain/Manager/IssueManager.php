<?php

declare(strict_types=1);

namespace App\Issue\Domain\Manager;


use App\Issue\Application\Resource\IssueResource;
use App\Issue\Application\Resource\IssueResrouceInterface;
use App\Issue\ContextContract\IssueProductInterface;
use App\Issue\ContextContract\IssueUserInterface;
use App\Issue\Domain\Model\IssueModel;
use App\Issue\Domain\Storage\IssueStorageInterface;
use DomainException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class IssueManager
{

    private IssueStorageInterface $storage;
    private IssueProductInterface $productStorage;
    private IssueUserInterface $userStorage;
    private ValidatorInterface $validator;

    /**
     * IssueManager constructor.
     * @param IssueStorageInterface $storage
     * @param IssueProductInterface $productStorage
     * @param IssueUserInterface $userStorage
     * @param ValidatorInterface $validator
     */
    public function __construct(IssueStorageInterface $storage, IssueProductInterface $productStorage, IssueUserInterface $userStorage, ValidatorInterface $validator)
    {
        $this->storage = $storage;
        $this->productStorage = $productStorage;
        $this->userStorage = $userStorage;
        $this->validator = $validator;
    }


    public function createIssue(IssueModel $model, string $username): IssueModel
    {
        $user = $this->userStorage->findOneBy(['email' => $username]);
        $model->setEmployee(null);
        $model->setUser($user);

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

    public function assignEmployeeToIssue(IssueModel $model): IssueModel
    {
        $employee = $this->userStorage->findOneBy(['email' => $model->getEmployee()->getUsername()]);
        $model->setEmployee($employee);

        $validationErrors = $this->validator->validate($model);

        if ($validationErrors->count() !== 0) {
            throw new DomainException("Domain model is not valid.");
        }

        try {
            return $this->storage->assignEmployee($model);
        } catch (\Exception $e) {
            throw new DomainException($e->getMessage());
        }
    }

    public function getProductIssues(string $productId): array
    {
        return $this->storage->findProductIssues($productId);
    }

    public function getIssue(string $id): IssueModel
    {
        return $this->storage->findIssueById($id);
    }

    public function getAllUserIssues(string $username): array
    {
        return $this->storage->getAllUserIssues($username);
    }

    public function getAllIssues(): array
    {
        return $this->storage->getAllIssues();
    }

    public function getSolvedIssues(): array
    {
        return $this->storage->getAllIssuesByRowValue('isSolved', 1);
    }

    public function getUserSolvedIssues($username): array
    {
        return $this->storage->getAllSolvedUserIssues($username);
    }

    public function updateIssue(IssueModel $model): IssueModel
    {
        return $this->storage->update($model);
    }

}