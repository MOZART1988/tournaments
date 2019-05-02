<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 10:27
 */

namespace Tournament;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Db\Adapter;

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
            Adapter\Adapter::class => function($container) {
                $config = $container->get('config');
                return new Adapter\Adapter($config['db']);
            }
        ];
    }
}