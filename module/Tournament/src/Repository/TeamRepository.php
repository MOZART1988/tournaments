<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 16:45
 */

namespace Tournament\Repository;


use Doctrine\ORM\EntityRepository;
use Tournament\Entity\Team;

class TeamRepository extends EntityRepository
{
    public function findVersusTeams($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('t')
            ->from(Team::class, 't')->where("t.id <> $id")
            ->getQuery()->getResult();
    }
}