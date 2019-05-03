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
     * @var array $groups
    */

    const GROUP_A = 1;
    const GROUP_B = 2;
    const GROUP_C = 3;
    const GROUP_D = 4;

    public static $groups = [
        self::GROUP_A => 'А',
        self::GROUP_B => 'B',
        self::GROUP_C => 'C',
        self::GROUP_D => 'D'
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

            $this->entityManager->flush();
        }
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

        $this->generateGroups($tournament->getId());

    }

    public function deleteTournament($id) : void
    {
        $tournament = $this->entityManager->getRepository(Tournament::class)
            ->findOneBy(['id' => $id]);

        if ($tournament) {
            $this->entityManager->remove($tournament);
            $this->entityManager->flush();
        }
    }

    public function generateGroups($tournamentId)
    {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();

        $result = [];

        foreach ($teams as $team) {
            $result[] = $team->getId();
        }

        shuffle($result);

        $counter = 1;
        $currentGroup = self::GROUP_A;

        foreach ($result as $teamId) {

            $teamTournament = new TeamTournament();

            $teamTournament->setTeamId($teamId);
            $teamTournament->setGroupId($currentGroup);
            $teamTournament->setTournamentId($tournamentId);

            $this->entityManager->persist($teamTournament);
            $this->entityManager->flush();

            if ($counter % 4 === 0) {
                $currentGroup++;
            }

            $counter++;
        }
    }
}