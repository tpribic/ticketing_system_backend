<?php

declare(strict_types=1);

namespace App\Issue\Application\ObjectTransformer;


use App\Common\ObjectTransformerInterface;
use App\Issue\Application\Resource\AssignIssueResource;
use App\Issue\Application\Resource\IssueResource;
use App\Issue\ContextContract\IssueProductInterface;
use App\Issue\ContextContract\IssueUserInterface;
use App\Issue\Domain\Model\IssueModel;
use App\Issue\Infrastructure\Doctrine\Main\Repository\PriorityRepository;

final class IssueObjectTransformer implements ObjectTransformerInterface
{

    private IssueProductInterface $productStorage;
    private PriorityRepository $priorityStorage;
    private IssueUserInterface $userStorage;

    /**
     * IssueObjectTransformer constructor.
     * @param IssueProductInterface $productStorage
     * @param PriorityRepository $priorityStorage
     * @param IssueUserInterface $userStorage
     */
    public function __construct(IssueProductInterface $productStorage, PriorityRepository $priorityStorage, IssueUserInterface $userStorage)
    {
        $this->productStorage = $productStorage;
        $this->priorityStorage = $priorityStorage;
        $this->userStorage = $userStorage;
    }

    public function fromDomain(object $model): object
    {
        $issueResource = new IssueResource();
        $issueResource
            ->setName($model->getName())
            ->setDescription($model->getDescription())
            ->setSerialNumber($model->getProduct()->getSerialNumber())
            ->setIsSolved($model->isSolved())
            ->setPriority($model->getPriority()->getId())
            ->setUser($model->getUser())
            ->setEmployee($model->getEmployee());

        return $issueResource;
    }

    public function toDomain(object $resource): object
    {
        $issueModel = new IssueModel();

        if ($resource instanceof AssignIssueResource) {
            $employee = $this->userStorage->findOneBy(['email' => $resource->getEmployeeUsername()]);
            $issueModel->setId($resource->getIssueId());
            $issueModel->setEmployee($employee);
            return $issueModel;
        }

        $product = $this->productStorage->findOneBy(['serial_number' => $resource->getSerialNumber()]);
        $priority = $this->priorityStorage->findOneBy(['id' => $resource->getPriority()]);

        $issueModel
            ->setName($resource->getName())
            ->setDescription($resource->getDescription())
            ->setIsSolved($resource->isSolved())
            ->setPriority($priority)
            ->setProduct($product);

        return $issueModel;
    }
}