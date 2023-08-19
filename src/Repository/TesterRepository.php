<?php

namespace App\Repository;

use App\Entity\Tester;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends UserRepository<Tester>
 *
 * @method Tester|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tester|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tester[]    findAll()
 * @method Tester[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TesterRepository extends UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tester::class);
    }
}
