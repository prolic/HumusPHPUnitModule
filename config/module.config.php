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
                        'route'    => 'humusphpunit [--modules=] [--colors] [--stderr] [--strict] [--verbose|-v] [--debug] [--process-isolation] [--help|-h] [--version]',
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
