<?php

namespace HumusPHPUnitModule;

class Runner implements RunnerInterface
{
    /**
     * @var array
     */
    protected $tests;

    public function __construct(array $tests = array())
    {
        $this->tests = $tests;
    }

    /**
     * Runs all unit tests
     *
     * @return void
     */
    public function run()
    {
        echo "Humus PHPUnit Module for Zend Framework 2\n";
        echo "Author: Sascha-Oliver Prolic\n\n";
        foreach ($this->getTests() as $module => $paths) {
            echo 'Testing Module: ' . $module . "\n";
            foreach ($paths as $path) {
                passthru('phpunit -c ' . $path);
            }

        }
        echo "\nAll done.";
    }

    /**
     * Get all tests
     *
     * @return array
     */
    public function getTests()
    {
        return $this->tests;
    }

}