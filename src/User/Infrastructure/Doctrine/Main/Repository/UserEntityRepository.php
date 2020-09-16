<?php

namespace App\User\Infrastructure\Doctrine\Main\Repository;

use App\User\Domain\Model\UserModel;
use App\User\Domain\Storage\UserStorageInterface;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use App\User\Domain\ObjectTransformer\UserObjectTransformerFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntity[]    findAll()
 * @method UserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserStorageInterface
{

    private UserObjectTransformerFactory $transformer;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(ManagerRegistry $registry, UserObjectTransformerFactory $userObjectTransformer, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, UserEntity::class);
        $this->transformer = $userObjectTransformer;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof UserEntity) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function save(UserModel $model): UserModel
    {
        $userEntity = $this->transformer->fromDomain($model);

        $encodedPassword = $this->passwordEncoder->encodePassword($userEntity, $userEntity->getPassword());
        $userEntity->setPassword($encodedPassword);
        $this->_em->persist($userEntity);
        $this->_em->flush();

        return $this->transformer->toDomain($userEntity);
    }

    public function delete(string $id): void
    {
        $user = $this->find($id);
        $this->_em->remove($user);
        $this->_em->flush();
    }
    // /**
    //  * @return UserEntity[] Returns an array of UserEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserEntity
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
