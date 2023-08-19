<?php

namespace App\Repository;

use App\Entity\CommonUser;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends UserRepository<CommonUser>
 *
 * @method CommonUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommonUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommonUser[]    findAll()
 * @method CommonUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommonUserRepository extends UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommonUser::class);
    }
}
