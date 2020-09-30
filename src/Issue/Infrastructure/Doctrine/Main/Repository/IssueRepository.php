<?php

namespace App\Issue\Infrastructure\Doctrine\Main\Repository;

use App\Issue\Domain\Model\IssueModel;
use App\Issue\Domain\Storage\IssueStorageInterface;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Issue;
use App\Issue\Infrastructure\ObjectTransformer\IssueEntityObjectTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Issue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Issue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Issue[]    findAll()
 * @method Issue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class IssueRepository extends ServiceEntityRepository implements IssueStorageInterface
{

    private IssueEntityObjectTransformer $objectTransformer;

    public function __construct(ManagerRegistry $registry, IssueEntityObjectTransformer $objectTransformer)
    {
        parent::__construct($registry, Issue::class);
        $this->objectTransformer = $objectTransformer;
    }

    public function save(IssueModel $model): IssueModel
    {
        $issueEntity = $this->objectTransformer->fromDomain($model);

        $this->_em->persist($issueEntity);
        $this->_em->flush();

        return $this->objectTransformer->toDomain($issueEntity);
    }

    public function update(IssueModel $model): IssueModel
    {
        $issueEntity = $this->findOneBy(['id' => $model->getId()]);
        $issueEntity
            ->setPriority($model->getPriority())
            ->setEmployee($model->getEmployee())
            ->setIsSolved($model->isSolved());

        $this->_em->persist($issueEntity);
        $this->_em->flush();

        return $this->objectTransformer->toDomain($issueEntity);
    }

    public function assignEmployee(IssueModel $model): IssueModel
    {
        $issueEntity = $this->findOneBy(['id' => $model->getId()]);
        $issueEntity->setEmployee($model->getEmployee());
        $this->_em->persist($issueEntity);
        $this->_em->flush();

        return $this->objectTransformer->toDomain($issueEntity);
    }

    public function findProductIssues($productId)
    {
        $result = $this->findBy(['product' => $productId]);
        $models = [];
        foreach ($result as $issue) {
            $models[] = $this->objectTransformer->toDomain($issue);
        }
        return $models;
    }

    public function findIssueById($id): IssueModel
    {
//        $result = $this->findOneBy(['id' => $id]);
        $result = $this->_em->getReference(Issue::class, $id);
        return $this->objectTransformer->toDomain($result);
    }

    public function getAllUserIssues(string $username): array
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->join('i.user', 'u')
            ->where('u.email = :username')
            ->setParameters([':username' => $username])
            ->getQuery()
            ->getResult();

        $models = [];
        foreach ($query as $issue) {
            $models[] = $this->objectTransformer->toDomain($issue);
        }

        return $models;
    }

    public function getAllIssues(): array
    {
        $result = $this->findAll();
        $models = [];
        foreach ($result as $issue) {
            $models[] = $this->objectTransformer->toDomain($issue);
        }
        return $models;
    }

    public function getAllIssuesByRowValue($row, $value): array
    {
        $issueEntities = $this->createQueryBuilder('p')
            ->andWhere(sprintf('p.%s = :val', $row))
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();

        $issueModels = [];

        foreach ($issueEntities as $entity) {
            $issueModels[] = $this->objectTransformer->toDomain($entity);
        }

        return $issueModels;
    }

    public function getAllSolvedUserIssues($username): array
    {
        $query = $this->createQueryBuilder('i')
            ->select('i')
            ->join('i.user', 'u')
            ->where('u.email = :username')
            ->andWhere('i.isSolved = 1')
            ->setParameters([':username' => $username])
            ->getQuery()
            ->getResult();

        $models = [];
        foreach ($query as $issue) {
            $models[] = $this->objectTransformer->toDomain($issue);
        }

        return $models;
    }
}
