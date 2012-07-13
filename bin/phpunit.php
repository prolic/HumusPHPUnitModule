<?php

use HumusPHPUnitModule\ModuleManager\Listener\PHPUnitListener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfiguration;

chdir(__DIR__ . '/../../../../');

include 'init_autoloader.php';

// Run the unit tests
$configuration = include 'config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($smConfig));
$serviceManager->setService('ApplicationConfiguration', $configuration);

$phpUnitListener = new PHPUnitListener;
$moduleManager = $serviceManager->get('ModuleManager');
/* @var $moduleManager  */
$moduleManager->getEventManager()->attach(ModuleEvent::EVENT_LOAD_MODULE, $phpUnitListener);
$moduleManager->loadModules();

echo "Humus PHPUnit Module for Zend Framework 2\n";
echo "Author: Sascha-Oliver Prolic\n\n";
foreach ($phpUnitListener->getPaths() as $module => $paths) {
    echo 'Testing Module: ' . $module . "\n";
    foreach ($paths as $path) {
        passthru('phpunit -c ' . $path);
    }

}
echo "\nAll done.";