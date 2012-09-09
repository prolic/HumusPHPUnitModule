<?php

use HumusPHPUnitModule\ModuleManager\Listener\PHPUnitListener;
use HumusPHPUnitModule\Runner;
use Zend\ModuleManager\ModuleEvent;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

chdir(__DIR__ . '/../../../../');

include 'init_autoloader.php';

// init the application
$configuration = include 'config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
$serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));
$serviceManager->setService('ApplicationConfiguration', $configuration);

// load the modules and attach phpunit listener
$moduleManager = $serviceManager->get('ModuleManager');
$moduleEventManager = $moduleManager->getEventManager();
$phpUnitListener = new PHPUnitListener();
$phpUnitListener->attach($moduleEventManager);
$moduleManager->loadModules();

// run all tests
$runner = $serviceManager->get('HumusPHPUnitModule\Runner');
$runner->run();
