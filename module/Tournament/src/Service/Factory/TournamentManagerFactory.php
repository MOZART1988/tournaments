<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.05.19
 * Time: 10:38
 */

namespace Tournament\Service\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TournamentManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
    }
}