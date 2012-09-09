<?php

namespace HumusPHPUnitModule\Service;

use HumusPHPUnitModule\Runner;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RunnerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $phpunitRunnerConfig = $config['humus_phpunit_module']['phpunit_runner'];
        return new Runner($phpunitRunnerConfig);
    }
}