<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 13:17
 */

namespace Tournament\Repository;


use Doctrine\ORM\EntityRepository;
use Tournament\Entity\TeamTournament;

class TeamTournamentRepository extends EntityRepository
{
    public function findWinnersGroupStage($groupId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('t')
            ->from(TeamTournament::class, 't')
            ->where("t.group_id=$groupId")
            ->orderBy('t.final_score', 'DESC')
            ->setMaxResults(4)
            ->getQuery()->getResult();
    }
}