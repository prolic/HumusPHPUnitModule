<?php

use HumusMvc\Service\ServiceManagerConfig as HumusServiceManagerConfig;
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

if (class_exists('HumusMvc\Service\ServiceManagerConfig')) {
    $config = new HumusServiceManagerConfig($smConfig);
    // only useful with HumusMvc
} else {
    // use zf2 with zf2 skeleton app
    $config = new ServiceManagerConfig($smConfig);
}
$serviceManager = new ServiceManager($config);
$serviceManager->setService('ApplicationConfig', $configuration);

// load the modules and attach phpunit listener
$moduleManager = $serviceManager->get('ModuleManager');
$moduleEventManager = $moduleManager->getEventManager();
$phpUnitListener = new PHPUnitListener();
$phpUnitListener->attach($moduleEventManager);
$moduleManager->loadModules();

// run all tests
$runner = $serviceManager->get('HumusPHPUnitRunner');
$runner->run();
