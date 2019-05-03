<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 16:36
 */

namespace Tournament\Service;


use Doctrine\ORM\EntityManager;
use Tournament\Entity\Game;
use Tournament\Entity\Team;
use Tournament\Entity\TeamTournament;

class GameManager
{
    /**
     * List of Stages
     */

    const STAGE_GROUP = 1;
    const STAGE_QURTER_FINAL = 2;
    const STAGE_SEMI_FINAL = 3;
    const STAGE_FINAL = 4;

    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addGame($data) : Game
    {
        $game = new Game();

        $game->setTournamentId($data['tournamentId']);
        $game->setStageId($data['stageId']);
        $game->setFirstTeamId($data['firstTeamId']);
        $game->setSecondTeamId($data['secondTeamId']);
        $game->setFirstTeamScore(random_int(0, 10));
        $game->setSecondTeamScore(random_int(0, 10));

        $this->entityManager->persist($game);

        $this->entityManager->flush();

        return $game;
    }

    public function generateGameTable($tournamentId, $divisionId) : void
    {
        $teamTournamentsStage1 = $this->entityManager->getRepository(TeamTournament::class)
            ->findBy(['tournament_id' => $tournamentId, 'group_id' => $divisionId]);

        foreach ($teamTournamentsStage1 as $item) {
            /**
             * @var TeamTournament $item
             */

            $versusTeams = $this->entityManager->getRepository(Team::class)
                ->findVersusTeams($item->getTeamId());


            if (!empty($versusTeams)) {
                foreach ($versusTeams as $versusTeam) {
                    /**
                     * @var Team $versusTeam
                     */

                    $data = [
                        'tournamentId' => $tournamentId,
                        'stageId' => self::STAGE_GROUP,
                        'firstTeamId' => $item->getTeamId(),
                        'secondTeamId' => $versusTeam->getId(),
                    ];

                    $this->playGame($this->addGame($data));
                }

            }
        }
    }

    public function playGame(Game $game)
    {
        $firstTeam = $game->getFirstTeam();
        $secondTeam = $game->getSecondTeam();

        /**
         * @var TeamTournament $firstTeam
         * @var TeamTournament $secondTeam
         */

        if ($game->getFirstTeamScore() > $game->getSecondTeamScore()) {
            $firstTeam->setFinalScore($firstTeam->getFinalScore() + 3);
        }

        if ($game->getFirstTeamScore() < $game->getSecondTeamScore()) {
            $secondTeam->setFinalScore($secondTeam->getFinalScore() + 3);
        }

        if ($game->getFirstTeamScore() === $game->getSecondTeamScore()) {
            $firstTeam->setFinalScore($firstTeam->getFinalScore() + 1);
            $secondTeam->setFinalScore($secondTeam->getFinalScore() + 1);
        }

        $this->entityManager->persist($firstTeam);
        $this->entityManager->persist($secondTeam);

        $this->entityManager->flush();
    }
}