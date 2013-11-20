<?php
return array(
    'humus_phpunit_module' => array(
        'phpunit_runner' => array(
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'HumusPHPUnitRunner' => 'HumusPHPUnitModule\Service\RunnerFactory',
        )
    ),
    'controllers' => array(
        'factories' => array(
            'HumusPHPUnitController' => 'HumusPHPUnitModule\Service\ControllerFactory'
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'humusphpunit' => array(
                    'options' => array(
                        'route'    => 'humusphpunit [--modules=] [--stop-on-module-failure] [--colors] [--stderr] [--stop-on-error] [--stop-on-failure] [--stop-on-skipped] [--stop-on-incomplete] [--strict] [--verbose|-v] [--debug] [--process-isolation] [--no-globals-backup] [--static-backup] [--help|-h] [--version]',
                        'defaults' => array(
                            'controller' => 'HumusPHPUnitController',
                            'action'     => 'run'
                        )
                    )
                )
            )
        )
    )
);
