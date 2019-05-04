<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 12:47
 */

namespace Tournament\Controller;


use Doctrine\ORM\EntityManager;
use Tournament\Entity\Game;
use Tournament\Entity\TeamTournament;
use Tournament\Entity\Tournament;
use Tournament\Service\GameManager;
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
     * @var GameManager $gameManager
    */

    private $gameManager;

    public function __construct(EntityManager $entityManager, GameManager $gameManager)
    {
        $this->entityManager = $entityManager;
        $this->gameManager = $gameManager;
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

    public function tableAction()
    {
        $id = $this->params()->fromRoute('id', -1);

        $this->gameManager->generatePlayOffTable($id);

        $groupOneGames = $this->entityManager->getRepository(Game::class)
            ->findBy(['tournament_id' => $id, 'stage_id' => GameManager::STAGE_GROUP]);
        $groupTwoGames = $this->entityManager->getRepository(Game::class)
            ->findBy(['tournament_id' => $id, 'stage_id' => GameManager::STAGE_QURTER_FINAL]);
        $groupThreeGames = $this->entityManager->getRepository(Game::class)
            ->findBy(['tournament_id' => $id, 'stage_id' => GameManager::STAGE_SEMI_FINAL]);
        $groupFinalGames = $this->entityManager->getRepository(Game::class)
            ->findBy(['tournament_id' => $id, 'stage_id' => GameManager::STAGE_FINAL]);

        return new ViewModel([
            'groupOneGames' => $groupOneGames,
            'groupTwoGames' => $groupTwoGames,
            'groupThreeGames' => $groupThreeGames,
            'groupFinalGames' => $groupFinalGames,
            'tournament' => $this->entityManager->getRepository(Tournament::class)
            ->findOneBy(['id' => $id])
        ]);
    }
}