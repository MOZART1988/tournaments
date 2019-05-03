<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 12:47
 */

namespace Tournament\Controller;


use Doctrine\ORM\EntityManager;
use Tournament\Entity\TeamTournament;
use Tournament\Entity\Tournament;
use Tournament\Service\TournamentManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TournamentManager
     */
    private $tournamentManager;

    public function __construct(EntityManager $entityManager, TournamentManager $tournamentManager)
    {
        $this->entityManager = $entityManager;
        $this->tournamentManager = $tournamentManager;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id', -1);

        $tournament = $this->entityManager->getRepository(Tournament::class)->findOneBy(['id' => $id]);

        if ($tournament === null) {
            $this->getResponse()->setStatusCode(404);
        }

        return new ViewModel([
            'divisionOneTeams' => $this->entityManager->getRepository(TeamTournament::class)
                ->findBy(['tournament_id' => $tournament->getId(), 'group_id' => TournamentManager::DIVISION_1]),
            'divisionTwoTeams' => $this->entityManager->getRepository(TeamTournament::class)
                ->findBy(['tournament_id' => $tournament->getId(), 'group_id' => TournamentManager::DIVISION_2]),
            'tournament' => $tournament,
        ]);
    }
}