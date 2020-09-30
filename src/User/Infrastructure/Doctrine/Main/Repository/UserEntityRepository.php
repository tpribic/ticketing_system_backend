<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Main\Repository;

use App\Issue\ContextContract\CommentUserInterface;
use App\Issue\ContextContract\IssueUserInterface;
use App\Product\Domain\ContextContract\ProductUserInterface;
use App\User\Domain\Model\UserModel;
use App\User\Domain\Storage\UserStorageInterface;
use App\User\Infrastructure\Doctrine\Exception\UserAlreadyExistsException;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use App\User\Domain\ObjectTransformer\UserObjectTransformerFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
class UserEntityRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserStorageInterface, ProductUserInterface, IssueUserInterface, CommentUserInterface
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
        try {
            $this->_em->persist($userEntity);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new UserAlreadyExistsException();
        }

        return $this->transformer->toDomain($userEntity);
    }

    public function delete(string $id): void
    {
        $user = $this->find($id);
        $this->_em->remove($user);
        $this->_em->flush();
    }

    public function getEmployees(): array
    {
        $result = $this->findByRole('ROLE_EMPLOYEE');
        return $result;
    }

    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
