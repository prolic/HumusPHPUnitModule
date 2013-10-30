<?php

namespace HumusPHPUnitModuleTest\Service;

use HumusPHPUnitModule\Module;
use HumusPHPUnitModule\Service\RunnerFactory;
use Zend\ServiceManager\ServiceManager;

class RunnerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $sm = new ServiceManager();

        $sm->setService('Config', array(
            'humus_phpunit_module' => array(
                'phpunit_runner' => array(
                    'path/to/phpunit.xml'
                )
            )
        ));

        $console = $this->getMockForAbstractClass('Zend\Console\Adapter\AdapterInterface');
        $sm->setService('console', $console);

        $module = new Module();
        $sm->setService('HumusPHPUnitModule\Module', $module);

        $factory = new RunnerFactory();
        $runner = $factory->createService($sm);

        $this->assertInstanceOf('HumusPHPUnitModule\RunnerInterface', $runner);
        $this->assertInstanceOf('HumusPHPUnitModule\Runner', $runner);

        $prop = new \ReflectionProperty(get_class($runner), 'tests');
        $prop->setAccessible(true);
        $value = $prop->getValue($runner);

        $this->assertEquals(array('path/to/phpunit.xml'), $value);
    }
}
