<?php

namespace HumusPHPUnitModuleTest;

use HumusPHPUnitModule\Module;
use Traversable;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();
        $this->assertInternalType('array', $config);
    }

    public function testGetAutoloaderConfig()
    {
        $module = new Module();
        $config = $module->getAutoloaderConfig();
        if (!is_array($config) && !($config instanceof Traversable)) {
            $this->fail('getAutoloaderConfig expected to return array or Traversable');
        }
    }

    public function testGetConsoleUsage()
    {
        $console = $this->getMockForAbstractClass('Zend\Console\Adapter\AdapterInterface');
        $module = new Module();
        $usage = $module->getConsoleUsage($console);
        $this->assertInternalType('array', $usage);
    }
}
