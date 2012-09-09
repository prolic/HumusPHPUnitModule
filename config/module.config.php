<?php
return array(
    'humus_phpunit_module' => array(
        'phpunit_runner' => array(
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'HumusPHPUnitRunner' => 'HumusPHPUnitModule\Service\RunnerFactory'
        )
    )
);