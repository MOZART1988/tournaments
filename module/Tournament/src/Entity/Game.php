<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 17:32
 */

namespace Tournament\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a game entity in a tournament.
 * @ORM\Entity(repositoryClass="\Tournament\Repository\GameRepository")
 * @ORM\Table(name="game")
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="title")
     */
    protected $title;

    /**
     * @ORM\Column(name="created_at")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="tournament_id")
     */
    protected $tournament_id;

    /**
     * @ORM\Column(name="first_team_id")
     */
    protected $first_team_id;

    /**
     * @ORM\Column(name="second_team_id")
     */
    protected $second_team_id;

    /**
     * @ORM\Column(name="first_team_score")
     */
    protected $first_team_score;

    /**
     * @ORM\Column(name="second_team_score")
     */
    protected $second_team_score;

    /**
     * @ORM\Column(name="stage_id")
     */
    protected $stage_id;

    /**
     * Returns ID of this team.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets ID of this team.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns title.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the date when this team was created.
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Sets the date when this team was created.
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns $tournament_id.
     * @return integer $tournament_id
     */
    public function getTournamentId()
    {
        return $this->tournament_id;
    }

    /**
     * Sets tournament_id.
     * @param integer $tournamentId
     */
    public function setTournamentId($tournamentId)
    {
        $this->tournament_id = $tournamentId;
    }

    /**
     * Returns $first_team_id.
     * @return integer $first_team_id
     */
    public function getFirstTeamId()
    {
        return $this->first_team_id;
    }

    /**
     * Sets $first_team_id.
     * @param integer $firstTeamId
     */
    public function setFirstTeamId($firstTeamId)
    {
        $this->first_team_id = $firstTeamId;
    }

    /**
     * Returns $second_team_id.
     * @return integer $second_team_id
     */
    public function getSecondTeamId()
    {
        return $this->second_team_id;
    }

    /**
     * Sets $second_team_id.
     * @param integer $secondTeamId
     */
    public function setSecondTeamId($secondTeamId)
    {
        $this->second_team_id = $secondTeamId;
    }

    /**
     * Returns $stage_id.
     * @return integer $stage_id
     */
    public function getStageId()
    {
        return $this->stage_id;
    }

    /**
     * Sets $stage_id.
     * @param integer $stageId
     */
    public function setStageId($stageId)
    {
        $this->stage_id = $stageId;
    }

    /**
     * Returns $first_team_score.
     * @return integer $first_team_score
     */
    public function getFirstTeamScore()
    {
        return $this->first_team_score;
    }

    /**
     * Sets $first_team_score.
     * @param integer $firstTeamScore
     */
    public function setFirstTeamScore($firstTeamScore)
    {
        $this->first_team_score = $firstTeamScore;
    }

    /**
     * Returns $second_team_score.
     * @return integer $second_team_score
     */
    public function getSecondTeamScore()
    {
        return $this->second_team_score;
    }

    /**
     * Sets $second_team_score.
     * @param integer $secondTeamScore
     */
    public function setSecondTeamScore($secondTeamScore)
    {
        $this->second_team_score = $secondTeamScore;
    }

}