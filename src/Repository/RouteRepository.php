<?php

namespace App\Repository;

use App\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Route>
 *
 * @method Route|null find($id, $lockMode = null, $lockVersion = null)
 * @method Route|null findOneBy(array $criteria, array $orderBy = null)
 * @method Route[]    findAll()
 * @method Route[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    public function save(Route $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Route $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByIdAndOwner(int $id, int $ownerId): ?Route
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :id')
            ->andWhere('r.owner = :ownerId')
            ->setParameter('id', $id)
            ->setParameter('ownerId', $ownerId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findBySetAndOwner(int $setId, int $ownerId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.set = :setId')
            ->andWhere('r.owner = :ownerId')
            ->setParameter('setId', $setId)
            ->setParameter('ownerId', $ownerId)
            ->getQuery()
            ->getResult();
    }
}
