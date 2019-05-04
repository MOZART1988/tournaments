<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 16:36
 */

namespace Tournament\Service\Factory;


use Interop\Container\ContainerInterface;
use Tournament\Service\GameManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class GameManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new GameManager($entityManager);
    }
}