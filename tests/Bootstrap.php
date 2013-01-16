<?php

use HumusPHPUnitModuleTest\ServiceManagerTestCase;

chdir(__DIR__);

if (
    ! ($loader = @include __DIR__ . '/../vendor/autoload.php')
    && ! ($loader = @include __DIR__ . '/../../../autoload.php')
) {
    throw new RuntimeException('vendor/autoload.php could not be found. Run composer installation');
}

$loader->add('DoctrineModuleTest\\', __DIR__);

if (!$config = @include __DIR__ . '/TestConfiguration.php') {
    $config = require __DIR__ . '/TestConfiguration.php.dist';
}

ServiceManagerTestCase::setServiceManagerConfiguration(
    isset($configuration['service_manager']) ? $configuration['service_manager'] : array()
);
