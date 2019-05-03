<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 11:22
 */

namespace Tournament\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a game entity in a team_tournament.
 * @ORM\Entity(repositoryClass="\Tournament\Repository\TeamTournamentRepository")
 * @ORM\Table(name="game")
 */
class TeamTournament
{
    /**
     * @ORM\Column(name="team_id")
     */
    protected $team_id;

    /**
     * @ORM\Column(name="tournament_id")
     */
    protected $tournament_id;

    /**
     * @ORM\Column(name="group_id")
     */
    protected $group_id;

    /**
     * Returns $team_id.
     * @return integer
     */
    public function getTeamId()
    {
        return $this->team_id;
    }

    /**
     * Sets $team_id.
     * @param int $teamId
     */
    public function setId($teamId)
    {
        $this->team_id = $teamId;
    }

    /**
     * Returns $tournament_id.
     * @return int
     */
    public function getTournamentId()
    {
        return $this->tournament_id;
    }

    /**
     * Sets $tournament_id.
     * @param int $tournamentId
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournament_id = $tournamentId;
    }

    /**
     * Returns $group_id.
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Sets $group_id.
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->group_id = $groupId;
    }
}