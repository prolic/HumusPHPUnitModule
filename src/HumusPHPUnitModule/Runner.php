<?php

namespace HumusPHPUnitModule;

class Runner implements RunnerInterface
{
    const CONSOLE_CHAR_LENGTH = 70;
    
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
        echo "Author: Sascha-Oliver Prolic\n";
        foreach ($this->getTests() as $module => $paths) {
            echo $this->getModuleOutput($module);
            foreach ($paths as $path) {
                passthru('vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'phpunit -c ' . $path);
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

    /**
     * Get a beautiful output
     * 
     * @param string $module
     * @return string
     */
    protected function getModuleOutput($module)
    {
        $moduleString = 'Testing Module: ' . $module;
        
        $spaceLeft = 0;
        $spaceRight = 0;
        
        $length = strlen($moduleString);
        $lengthLeft = (self::CONSOLE_CHAR_LENGTH - $length - 2) / 2;
        if ($lengthLeft % 2 === 0) {
            //even
            $spaceLeft = $lengthLeft;
            $spaceRight = $lengthLeft;
        } else {
            $spaceLeft = floor($lengthLeft);
            $spaceRight = round($lengthLeft, 0);
        }
        
        $output = PHP_EOL . str_repeat('*', static::CONSOLE_CHAR_LENGTH) . PHP_EOL;
        $output .= '*' . str_repeat(' ', $spaceLeft) . $moduleString . str_repeat(' ', $spaceRight) . '*' . PHP_EOL;
        $output .= str_repeat('*', static::CONSOLE_CHAR_LENGTH) . PHP_EOL;
        
        return $output;
    }
}
