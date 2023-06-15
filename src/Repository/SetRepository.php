<?php

namespace App\Repository;

use App\Entity\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Set>
 *
 * @method Set|null find($id, $lockMode = null, $lockVersion = null)
 * @method Set|null findOneBy(array $criteria, array $orderBy = null)
 * @method Set[]    findAll()
 * @method Set[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private RouteRepository $routeRepository, private PointRepository $pointRepository)
    {
        parent::__construct($registry, Set::class);
    }

    public function save(Set $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Set $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function removeRoutes(Set $entity, bool $flush = false): void {
        $routes = $entity->getRoutes();

        foreach ($routes as $route) {
            $this->routeRepository->remove($route);

            $points = $route->getPoints();

            foreach ($points as $point) {
                $point->setRoute(null);
                $this->pointRepository->save($point);
            }

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        }
    }
}
