<?php

namespace HumusPHPUnitModule\ModuleManager\Feature;

interface PHPUnitProviderInterface
{
    /**
     * Get the path to the phpunit config
     *
     * @return string
     */
    public function getPHPUnitXmlPath();
}