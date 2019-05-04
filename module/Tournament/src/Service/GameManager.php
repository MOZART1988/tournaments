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

    public function addGame($data, $stage) : Game
    {
        $game = new Game();

        $game->setTournamentId($data['tournamentId']);
        $game->setTitle('test');
        $game->setCreatedAt(date('Y-m-d H:i:s'));
        $game->setStageId($stage);
        $game->setFirstTeamId($data['firstTeamId']);
        $game->setSecondTeamId($data['secondTeamId']);
        $game->setFirstTeamScore(random_int(0, 10));
        $game->setSecondTeamScore(random_int(0, 10));
        $game->setFirstTeam(
            $this->entityManager->getRepository(Team::class)
            ->findOneBy(['id' => $data['firstTeamId']])
        );
        $game->setSecondTeam(
            $this->entityManager->getRepository(Team::class)
                ->findOneBy(['id' => $data['secondTeamId']])
        );

        $this->entityManager->persist($game);

        $this->entityManager->flush();

        return $game;
    }

    public function playGroupStage($tournamentId) : void
    {

        foreach (TournamentManager::$divisions as $divisionId => $divisionName) {

            $teams = $this->entityManager->getRepository(TeamTournament::class)
                ->findBy(['tournament_id' => $tournamentId, 'group_id' => $divisionId]);

            foreach ($teams as $item) {
                /**
                 * @var TeamTournament $item
                 */

                $versusTeams = $this->entityManager->getRepository(TeamTournament::class)
                    ->findVersusTeams($item->getTeamId(), $divisionId);


                if (!empty($versusTeams)) {
                    foreach ($versusTeams as $versusTeam) {
                        /**
                         * @var TeamTournament $versusTeam
                         */

                        if (!empty($this->entityManager->getRepository(Game::class)
                            ->findExists($item->getTeamId()))) {
                            continue;
                        }

                        $data = [
                            'tournamentId' => $tournamentId,
                            'firstTeamId' => $item->getTeamId(),
                            'secondTeamId' => $versusTeam->getTeamId(),
                        ];

                        $this->playGame($this->addGame($data, self::STAGE_GROUP));
                    }

                }
            }
        }
    }

    public function generatePlayOffTable($tournamentId) : void
    {

        if (!$this->entityManager->getRepository(Game::class)
        ->findOneBy(['tournament_id' => $tournamentId, 'stage_id' => self::STAGE_FINAL])) {

            $games = $this->entityManager->getRepository(Game::class)
                ->findBy(['tournament_id' => $tournamentId]);

            foreach ($games as $game) {
                $this->entityManager->remove($game);
            }

            $this->entityManager->flush();

            //GROUP STAGE

            $this->playGroupStage($tournamentId);

            //STAGE QUATER FINALS

            $teams = array_column($this->entityManager->getRepository(TeamTournament::class)
                ->findWinnersGroup(8), 'team_id');

            $this->generatePlayOffGames($tournamentId, $teams, self::STAGE_QURTER_FINAL);

            //STAGE SEMI FINALS

            $teams = array_column($this->entityManager->getRepository(TeamTournament::class)
                ->findWinnersGroup(4), 'team_id');

            $this->generatePlayOffGames($tournamentId, $teams, self::STAGE_SEMI_FINAL);

            //STAGE FINALS

            $teams = array_column($this->entityManager->getRepository(TeamTournament::class)
                ->findWinnersGroup(2), 'team_id');


            $this->generatePlayOffGames($tournamentId, $teams, self::STAGE_FINAL);
        }

    }

    public function playGame(Game $game) : void
    {
        $firstTeam = $this->entityManager->getRepository(TeamTournament::class)
        ->findOneBy(['team_id' => $game->getFirstTeamId()]);
        $secondTeam = $this->entityManager->getRepository(TeamTournament::class)
        ->findOneBy(['team_id' => $game->getSecondTeamId()]);

        /**
         * @var TeamTournament $firstTeam
         * @var TeamTournament $secondTeam
         */

        if ($firstTeam !== null && $secondTeam !== null) {
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

    public function generatePlayOffGames($tournamentId, $teamsIds, $startStage)
    {
        if (empty($teamsIds)) {
            return false;
        }

        $data = [
            'tournamentId' => $tournamentId,
            'firstTeamId' => reset($teamsIds),
            'secondTeamId' => end($teamsIds),
        ];

        reset($teamsIds);
        unset ($teamsIds[key($teamsIds)]);
        end($teamsIds);
        unset($teamsIds[key($teamsIds)]);

        $this->playGame($this->addGame($data, $startStage));

        return $this->generatePlayOffGames($tournamentId, $teamsIds, $startStage);
    }
}