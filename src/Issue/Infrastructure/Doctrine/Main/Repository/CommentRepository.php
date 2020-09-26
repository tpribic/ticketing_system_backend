<?php

namespace App\Issue\Infrastructure\Doctrine\Main\Repository;

use App\Issue\Domain\Model\CommentModel;
use App\Issue\Domain\Storage\CommentStorageInterface;
use App\Issue\Infrastructure\Doctrine\Main\Entity\Comment;
use App\Issue\Infrastructure\ObjectTransformer\CommentEntityObjectTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CommentRepository extends ServiceEntityRepository implements CommentStorageInterface
{

    private CommentEntityObjectTransformer $objectTransformer;

    public function __construct(ManagerRegistry $registry, CommentEntityObjectTransformer $objectTransformer)
    {
        parent::__construct($registry, Comment::class);
        $this->objectTransformer = $objectTransformer;
    }

    public function save(CommentModel $model): CommentModel
    {
        $entity = $this->objectTransformer->fromDomain($model);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $this->objectTransformer->toDomain($entity);
    }

    public function getCommentsForIssue($issueId): array
    {
        $result = $this->findBy(['issue' => $issueId]);
        $models = [];
        foreach ($result as $issue) {
            $models[] = $this->objectTransformer->toDomain($issue);
        }
        return $models;
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
