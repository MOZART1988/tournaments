<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 10:35
 */

namespace Tournament\Service;


use Doctrine\ORM\EntityManager;
use Tournament\Entity\Team;
use Tournament\Entity\TeamTournament;
use Tournament\Entity\Tournament;

class TournamentManager
{
    /**
     * List of Groups
     * @var array $divisions
    */

    const DIVISION_1 = 1;
    const DIVISION_2 = 2;


    public static $divisions = [
        self::DIVISION_1 => 'Upper division',
        self::DIVISION_2 => 'Lower division'
    ];

    /**
     * This list of teams
     * @var array $teams
    */

    public static $teams = [
        1 => 'Team Secret',
        2 => 'Team Liquid',
        3 => 'Vega Squadron',
        4 => 'Evil Geniuses',
        5 => 'OG',
        6 => 'Vici Gaming',
        7 => 'Virtus Pro',
        8 => 'Newbee',
        9 => 'Gambit',
        10 => 'Empire',
        11 => 'Navi',
        12 => 'LGD',
        13 => 'LGD Young',
        14 => 'Aliance',
        15 => 'The Wings',
        16 => 'DC'
    ];

    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateTeams($data) : void
    {
        foreach ($data as $id => $title) {
            $team = new Team();
            $team->setCreatedAt(date('Y-m-d'));
            $team->setTitle($title);


            $this->entityManager->persist($team);
        }

        $this->entityManager->flush();
    }


    public function addNewTournament($data) : void
    {
        $tournament = new Tournament();
        $tournament->setTitle($data['title']);
        $tournament->setCreatedAt(date('Y-m-d H:i:s'));

        $this->entityManager->persist($tournament);

        $this->entityManager->flush();

        if (!$this->entityManager->getRepository(Team::class)->findBy([])) {
            $this->generateTeams(self::$teams);
        }

        $this->generateDivisions($tournament->getId());

    }

    public function deleteTournament($id) : void
    {
        $tournament = $this->entityManager->getRepository(Tournament::class)
            ->findOneBy(['id' => $id]);

        if ($tournament) {

            $tournamentTeams = $this->entityManager->getRepository(TeamTournament::class)
                ->findBy(['tournament_id' => $tournament->getId()]);

            foreach ($tournamentTeams as $tournamentTeam) {
                $this->entityManager->remove($tournamentTeam);
            }

            $this->entityManager->remove($tournament);
        }

        $this->entityManager->flush();
    }

    public function generateDivisions($tournamentId)
    {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();

        $result = [];

        foreach ($teams as $team) {
            $result[] = $team->getId();
        }

        shuffle($result);

        $counter = 1;
        $currentGroup = self::DIVISION_1;

        foreach ($result as $teamId) {

            $teamTournament = new TeamTournament();

            $teamTournament->setTeamId($teamId);
            $teamTournament->setGroupId($currentGroup);
            $teamTournament->setTournamentId($tournamentId);

            $this->entityManager->persist($teamTournament);

            if ($counter % 8 === 0) {
                $currentGroup++;
            }

            $counter++;
        }

        $this->entityManager->flush();
    }
}