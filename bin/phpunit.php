<?php

use HumusPHPUnitModule\ModuleManager\Listener\PHPUnitListener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfiguration;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(dirname(__DIR__)));

// Setup autoloading
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

var_dump($phpUnitListener->getPaths());
