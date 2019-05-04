<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 17:57
 */

namespace Tournament\Controller\Factories;


use Tournament\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Tournament\Service\GameManager;
use Tournament\Service\TournamentManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $gameManager = $container->get(GameManager::class);

        return new IndexController($entityManager, $gameManager);
    }
}