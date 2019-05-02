<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 13:41
 */

namespace Entity;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\Factory\InvokableFactory;

class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                MysqlMapper::class => InvokableFactory::class,
                Team::class => InvokableFactory::class,
            ]
        ];
    }
}