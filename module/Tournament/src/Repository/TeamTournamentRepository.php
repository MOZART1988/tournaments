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
    public function findWinnersGroup($limit)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('t')
            ->from(TeamTournament::class, 't')
            ->orderBy('t.final_score', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()->getArrayResult();
    }

    public function findVersusTeams($teamId, $groupId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('t')
            ->from(TeamTournament::class, 't')
            ->where("t.team_id <> $teamId")
            ->andWhere("t.group_id=$groupId")
            ->getQuery()->getResult();
    }
}