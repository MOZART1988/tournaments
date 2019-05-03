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

    public function generateStageGames($tournamentId, $stage, $divisionId) : void
    {
        $teamTournaments = $this->entityManager->getRepository(TeamTournament::class)
            ->findBy(['tournament_id' => $tournamentId, 'group_id' => $divisionId]);

        if ($stage === self::STAGE_GROUP) {

            foreach ($teamTournaments as $item) {
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

                        $game = new Game();
                        $game->setTournamentId($tournamentId);
                        $game->setStageId($stage);
                        $game->setFirstTeamId($item->getTeamId());
                        $game->setSecondTeamId($versusTeam->getId());
                        $game->setFirstTeamScore(random_int(0, 10));
                        $game->setSecondTeamScore(random_int(0, 10));

                        $this->entityManager->persist($game);
                    }
                }
            }
        }

        $this->entityManager->flush();
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