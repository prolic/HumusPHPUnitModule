Humus PHPUnit Module
====================

Humus PHPUnit Module is a Module for Zend Framework 2 for unit testing.

Installation
------------

put the following in your composer.json:

"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/prolic/HumusPHPUnitModule"
        }
    ],

and under the require section:

"prolic/humus-php-unit-module": "dev-master"

./composer update

Usage
-----

    cd vendor/bin
    ./phpunit

PHPUnitListener
-------------------

If you want that on of your modules gets testet by PHPUnit, you have to implement the 
HumusPHPUnitModule\ModuleManager\Feature\PHPUnitProviderInterface in your Module.php
You can also provide more then one phpunit.xml file as array.

Sample Module:

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