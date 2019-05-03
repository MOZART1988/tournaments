<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 17:57
 */

namespace Application\Controller\Factories;


use Application\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Tournament\Service\TournamentManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $tournamentManager = $container->get(TournamentManager::class);

        return new IndexController($entityManager, $tournamentManager);
    }
}