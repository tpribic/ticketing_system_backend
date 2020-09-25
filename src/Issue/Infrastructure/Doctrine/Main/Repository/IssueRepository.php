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

    // /**
    //  * @return Issue[] Returns an array of Issue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    */

    /*
    public function findOneBySomeField($value): ?Issue
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
