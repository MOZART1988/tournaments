<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Tournament\Entity\Game;
use Tournament\Entity\Team;
use Tournament\Entity\Tournament;
use Tournament\Form\AddTournamentForm;
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
        $form = new AddTournamentForm();

        $tournaments = $this->entityManager->getRepository(Tournament::class)->findAll();

        if ($this->request->isPost()) {
            $data = $this->params()->fromPost();


            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $this->tournamentManager->addNewTournament($data);

                return $this->redirect()->toRoute('application');

            }
        }

        return new ViewModel([
            'form' => $form,
            'tournaments' => $tournaments
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', -1);

        $tournament = $this->entityManager->getRepository(Tournament::class)
            ->findBy(['id' => $id]);

        if ($tournament === null) {
            $this->getResponse()->setStatusCode(404);
        }

        $this->tournamentManager->deleteTournament($id);

        return $this->redirect()->toRoute('application', ['action'=>'index']);
    }
}
