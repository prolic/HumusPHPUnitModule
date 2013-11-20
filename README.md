Humus PHPUnit Module
====================

[![Build Status](https://travis-ci.org/prolic/HumusPHPUnitModule.png?branch=master)](https://travis-ci.org/prolic/HumusPHPUnitModule)
[![Coverage Status](https://coveralls.io/repos/prolic/HumusPHPUnitModule/badge.png?branch=master)](https://coveralls.io/r/prolic/HumusPHPUnitModule?branch=master)
[![Total Downloads](https://poser.pugx.org/prolic/humus-phpunit-module/downloads.png)](https://packagist.org/packages/prolic/humus-phpunit-module)
[![Latest Stable Version](https://poser.pugx.org/prolic/humus-phpunit-module/v/stable.png)](https://packagist.org/packages/prolic/humus-phpunit-module)
[![Latest Unstable Version](https://poser.pugx.org/prolic/humus-phpunit-module/v/unstable.png)](https://packagist.org/packages/prolic/humus-phpunit-module)
[![Dependency Status](https://www.versioneye.com/package/php:prolic:humus-phpunit-module/badge.png)](https://www.versioneye.com/package/php:prolic:humus-phpunit-module)

Humus PHPUnit Module is a Module for Zend Framework 2 for unit testing. It is able to test all your zf2 modules and libraries at once.

If you install this module via composer, you will get phpunit installed via composer in your vendor directory, too. You don't have to have a running PHPUnit installation in your system, it will be installed as dependency.

You can also download and test the Humus PHPUnit Module Sample Application at https://github.com/prolic/HumusPHPUnitModuleSampleApp

UPDATES IN 1.2.0
----------------

 - Full ZF2 cli integration:
   You can start humusphpunit with "php public/index.php humusphpunit"
   The old way of "vendor/bin/humusphpunit" still works
 - Support for passing parameters to phpunit like: "--strict", "--debug", "--version", and so on.
 - Support for new parameters specific to HumusPHPUnitModule like: "--modules=" and "stop-on-module-failure"
 - Get list of available options with: "php public/index.php" or "php public/index.php humusphpunit --help"
 - Colorized output in console
 - Test coverage

UPDATES IN 1.1.0
----------------

 - Remove PHPUnitListener - ATTENTION: THIS IS A BC BREAK !!! You have to configure humus phpunit module with your module config from now on.
 - Remove dependency on EHER/PHPUnit, because PHPUnit now handles composer installation himself.
 - Remove dependency on complete Zend Framework 2, instead the required components are defined as dependency.

Dependencies
------------

 - PHP 5.3.3
 - [Zend Console (from ZF2)](https://github.com/zendframework/zf2)
 - [Zend Json (from ZF2)](https://github.com/zendframework/zf2)
 - [Zend ModuleManager (from ZF2)](https://github.com/zendframework/zf2)
 - [Zend MVC (from ZF2)](https://github.com/zendframework/zf2)
 - [Zend Text (from ZF2)](https://github.com/zendframework/zf2)
 -  Any application similar to the
    [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication) or
    [HumusMvcSkeletonApplication](https://github.com/prolic/HumusMvcSkeletonApplication)
 - [PHPUnit 3.7.*](http://www.phpunit.de)

Suggestions
-----------

 - [DBUnit 1.2.*](https://github.com/sebastianbergmann/dbunit)
 - [PHPUnit Selenium 1.2.*](https://github.com/sebastianbergmann/phpunit-selenium)
 - [Selenium Server Standalone 2.*](https://github.com/claylo/selenium-server-standalone)
 - [PHPUnit Story 1.*](https://github.com/sebastianbergmann/phpunit-story)

Installation
------------

 1.  Add `"prolic/humus-phpunit-module": "1.*"` to your `composer.json`
 2.  Run `php composer.phar install`
 3.  Enable the module in your `config/application.config.php` by adding `HumusPHPUnitModule` to `modules`

Usage
-----

    php public/index.php humusphpunit

or

    ./vendor/bin/humusphpunit

get help

    php public/index.php humusphpunit --help

or

    php public/index.php

Configuration
-------------

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
