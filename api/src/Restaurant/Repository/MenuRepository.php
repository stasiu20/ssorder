<?php

namespace App\Restaurant\Repository;

use App\Restaurant\Entity\MenuPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuPosition[]    findAll()
 * @method MenuPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuPosition::class);
    }
}
