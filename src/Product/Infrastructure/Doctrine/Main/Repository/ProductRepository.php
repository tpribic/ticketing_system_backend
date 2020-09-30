<?php

namespace App\Product\Infrastructure\Doctrine\Main\Repository;

use App\Issue\ContextContract\IssueProductInterface;
use App\Product\Domain\Model\Product as ProductModel;
use App\Product\Domain\Storage\ProductStorageInterface;
use App\Product\Infrastructure\Doctrine\Main\Entity\Product;
use App\Product\Infrastructure\Doctrine\Main\Exception\SerialNumberAlreadyExistsException;
use App\Product\Infrastructure\Doctrine\ObjectTransformer\ProductObjectTransformer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends ServiceEntityRepository implements ProductStorageInterface, IssueProductInterface
{
    private ProductObjectTransformer $objectTransformer;

    public function __construct(ManagerRegistry $registry, ProductObjectTransformer $objectTransformer)
    {
        parent::__construct($registry, Product::class);
        $this->objectTransformer = $objectTransformer;
    }

    public function save(ProductModel $model): ProductModel
    {
        $productEntity = $this->objectTransformer->fromDomain($model);

        if (null !== $this->findOneBy(['serial_number' => $model->getSerialNumber()])) {
            throw new SerialNumberAlreadyExistsException('Already Exists');
        }

        $this->_em->persist($productEntity);
        $this->_em->flush();

        return $this->objectTransformer->toDomain($productEntity);
    }

    /**
     * @param ProductModel $model
     * @throws EntityNotFoundException
     */
    public function activateProduct(object $model): object
    {
        $existingProduct = $this->findOneBy(['serial_number' => $model->getSerialNumber()]);

        if (!$existingProduct) {
            throw new EntityNotFoundException();
        }

        $existingProduct->setIsActive(true);
        $existingProduct->setUser($model->getUser());
        $this->_em->flush();

        return $this->objectTransformer->toDomain($existingProduct);
    }

    /**
     * @param string $userId
     * @return ProductModel[]
     */
    public function getUserProducts(string $userId): ?array
    {
        $productModels = [];
        $productEntities = $this->findBy(['user' => $userId]);

        foreach ($productEntities as $entity) {
            $productModels[] = $this->objectTransformer->toDomain($entity);
        }

        return $productModels;
    }

    public function getAllProducts(): array
    {
        $productEntities = $this->findAll();
        $productModels = [];

        foreach ($productEntities as $entity) {
            $productModels[] = $this->objectTransformer->toDomain($entity);
        }

        return $productModels;
    }

    public function getAllProductsByRowValue($row, $value): array
    {
        $productEntities = $this->createQueryBuilder('p')
            ->andWhere(sprintf('p.%s = :val', $row))
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();

        $productModels = [];

        foreach ($productEntities as $entity) {
            $productModels[] = $this->objectTransformer->toDomain($entity);
        }

        return $productModels;
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
