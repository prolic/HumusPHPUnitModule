<?php

namespace HumusPHPUnitModule\ModuleManager\Feature;

interface PHPUnitProviderInterface
{
    /**
     * Get the paths to the phpunit configs
     *
     * @return array
     */
    public function getPHPUnitXmlPaths();
}