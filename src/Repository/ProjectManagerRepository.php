<?php

namespace App\Repository;

use App\Entity\ProjectManager;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends UserRepository<ProjectManager>
 *
 * @method ProjectManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectManager[]    findAll()
 * @method ProjectManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectManagerRepository extends UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectManager::class);
    }
}
