<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.05.19
 * Time: 10:27
 */

namespace Tournament;


class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}