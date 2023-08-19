<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends UserRepository<Developer>
 *
 * @method Developer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developer[]    findAll()
 * @method Developer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperRepository extends UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }
}
