<?php

namespace HumusPHPUnitModule\ModuleManager\Listener;

use HumusPHPUnitModule\ModuleManager\Feature\PHPUnitProviderInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ModuleManager\ModuleEvent;

class PHPUnitListener
{

    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @param  ModuleEvent $e
     * @return PHPUnitListener
     */
    public function __invoke(ModuleEvent $e)
    {
        $module = $e->getParam('module');

        if (!$module instanceof PHPUnitProviderInterface
            && !is_callable(array($module, 'getPHPUnitXmlPath'))
        ) {
            return $this;
        }

        $phpUnitXmlPath = $module->getPHPUnitXmlPath();
        $this->addPHPUnitXmlPath($e->getModuleName(), $phpUnitXmlPath);

        return $this;
    }

    /**
     * Add phpunit xml path
     *
     * @param string $path
     * @return PHPUnitListener
     */
    public function addPHPUnitXmlPath($moduleName, $path)
    {
        $this->paths[$moduleName] = $path;
        return $this;
    }

    /**
     * Get phpunit xml paths
     *
     * - key is module name
     * - value is path
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

}