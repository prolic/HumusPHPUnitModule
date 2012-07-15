Humus PHPUnit Module
====================

Humus PHPUnit Module is a Module for Zend Framework 2 for unit testing. It is able to test all your zf2 modules and libraries at once.

You can also download and test the Humus PHPUnit Module Sample Application at https://github.com/prolic/HumusPHPUnitModuleSampleApp

Dependencies
------------

 -  [ZendFramework 2](https://github.com/zendframework/zf2).
 -  Any application similar to the
    [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication).
 -  [EHER/PHPUnit](https://github.com/EHER/phpunit-all-in-one)

Installation
------------

 1.  Add `"prolic/humus-phpunit-module": "dev-master"` to your `composer.json`
 2.  Run `php composer.phar install`
 3.  Enable the module in your `config/application.config.php` by adding `HumusPHPUnitModule` to `modules`

Usage
-----

    ./vendor/bin/phpunit

PHPUnitListener
-------------------

There are two ways to configure the PHPUnit Runner. You can also mix both.

 1. Implement the HumusPHPUnitModule\ModuleManager\Feature\PHPUnitProviderInterface in your module.
 2. Override the phpunit_runner configuration.

Using the PHPUnitProviderInterface
----------------------------------

Sample module:

    namespace MyModule;
    
    use HumusPHPUnitModule\ModuleManager\Feature\PHPUnitProviderInterface;
    
    class Module implements PHPUnitProviderInterface
    {
        public function getPHPUnitXmlPaths()
        {
            return array(
                dirname(dirname(__DIR__)) . '/tests/phpunit.xml'
            );
        }
    }

Using the Configuration
-----------------------

Sample configuration:

    <?php
    return array(
        'humus_phpunit_module' => array(
            'phpunit_runner' => array(
                'Doctrine\Common' => array(
                    'vendor/doctrine/common/phpunit.xml.dist'
                )
            )
        )
    );
