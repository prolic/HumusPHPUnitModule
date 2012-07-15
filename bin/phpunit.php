<?php

use HumusPHPUnitModule\ModuleManager\Listener\PHPUnitListener;
use HumusPHPUnitModule\Runner;
use Zend\ModuleManager\ModuleEvent;
use Zend\Mvc\Service\ServiceManagerConfiguration;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

chdir(__DIR__ . '/../../../../');

include 'init_autoloader.php';

// init the application
$configuration = include 'config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($smConfig));
$serviceManager->setService('ApplicationConfiguration', $configuration);

// load the modules
$phpUnitListener = new PHPUnitListener;
$moduleManager = $serviceManager->get('ModuleManager');
$moduleManager->getEventManager()->attach(ModuleEvent::EVENT_LOAD_MODULE, $phpUnitListener);
$moduleManager->loadModules();

// get the config
$config = $moduleManager->getEvent()->getConfigListener()->getMergedConfig();
$runnerConfig = ArrayUtils::merge($config['humus-phpunit-listener'], $phpUnitListener->getPaths());

// run all tests
$runner = new Runner($runnerConfig);
$runner->run();
