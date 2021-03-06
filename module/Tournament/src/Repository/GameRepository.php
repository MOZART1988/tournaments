<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 17:33
 */

namespace Tournament\Repository;


use Doctrine\ORM\EntityRepository;
use Tournament\Entity\Game;

class GameRepository extends EntityRepository
{
    public function findExists($teamId, $versusTeamId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        return $queryBuilder->select('g')
            ->from(Game::class, 'g')
            ->where("g.first_team_id=$versusTeamId")
            ->andWhere("g.second_team_id=$teamId")->getQuery()->getResult();
    }
}