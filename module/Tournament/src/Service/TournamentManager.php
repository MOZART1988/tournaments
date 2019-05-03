<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 10:35
 */

namespace Tournament\Service;


use Doctrine\ORM\EntityManager;
use Tournament\Entity\Tournament;

class TournamentManager
{
    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewTournament($data)
    {
        $tournament = new Tournament();
        $tournament->setTitle($data['title']);
        $tournament->setCreatedAt(date('Y-m-d H:i:s'));

        $this->entityManager->persist($tournament);

        $this->entityManager->flush();
    }
}