<?php

namespace HumusPHPUnitModule;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements ConfigProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'HumusPHPUnitRunner' => function(ServiceLocatorInterface $sl) {
                    $config = $sl->get('Configuration');
                    $phpunitRunnerConfig = $config['humus_phpunit_module']['phpunit_runner'];
                    return new Runner($phpunitRunnerConfig);
                }
            )
        );
    }
}
