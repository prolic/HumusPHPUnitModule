<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace HumusPHPUnitModule;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface;
use Zend\Stdlib\StringUtils;
use Zend\Text\Table;

class Runner implements RunnerInterface
{
    /**
     * @var array
     */
    protected $params = array();

    /**
     * @var array
     */
    protected $tests;

    /**
     * @var Console
     */
    protected $console;

    /**
     * @var array
     */
    protected $usage;

    /**
     * Constructor
     *
     * @param array $tests
     */
    public function __construct(array $tests = array())
    {
        $this->tests = $tests;
    }

    /**
     * Set parameters
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Runs all unit tests
     *
     * @return void
     */
    public function run()
    {
        echo $this->getTitle();

        $dir = 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR;

        if (false !== array_search('--version', $this->getParams())) {
            passthru($dir . 'phpunit --version');
            echo 'Humus PHPUnit Module ' . Version::VERSION;
            return;
        }

        if (false !== array_search('--help', $this->getParams())) {
            $console = $this->getConsole();

            $usage = $this->getUsage();
            if (!count($usage)) {
                return '';
            }

            echo "\n";

            $result    = '';
            $table     = false;
            $tableCols = 0;
            $tableType = 0;

            if (is_string($usage)) {
                // It's a plain string - output as is
                $result .= $usage . "\n";
                echo $result;
                return;
            }

            // It's an array, analyze it
            foreach ($usage as $a => $b) {
                /*
                 * 'invocation method' => 'explanation'
                 */
                if (is_string($a) && is_string($b)) {
                    if (($tableCols !== 2 || $tableType != 1) && $table !== false) {
                        // render last table
                        $result .= $this->renderTable($table, $tableCols, $console->getWidth());
                        $table   = false;

                        // add extra newline for clarity
                        $result .= "\n";
                    }

                    // Colorize the command
                    $a = $console->colorize($a, ColorInterface::GREEN);

                    $tableCols = 2;
                    $tableType = 1;
                    $table[]   = array($a, $b);
                    continue;
                }

                /*
                 * array('--param', '--explanation')
                 */
                if (is_array($b)) {
                    if ((count($b) != $tableCols || $tableType != 2) && $table !== false) {
                        // render last table
                        $result .= $this->renderTable($table, $tableCols, $console->getWidth());
                        $table   = false;

                        // add extra newline for clarity
                        $result .= "\n";
                    }

                    $tableCols = count($b);
                    $tableType = 2;
                    $table[]   = $b;
                    continue;
                }

                /*
                 * 'A single line of text'
                 */
                if ($table !== false) {
                    // render last table
                    $result .= $this->renderTable($table, $tableCols, $console->getWidth());
                    $table   = false;

                    // add extra newline for clarity
                    $result .= "\n";
                }

                $tableType = 0;
                $result   .= $b . "\n";
            }

            // Finish last table
            if ($table !== false) {
                $result .= $this->renderTable($table, $tableCols, $console->getWidth());
            }

            echo $result;
            return;
        }

        foreach ($this->getTests() as $module => $paths) {
            foreach ($paths as $path) {
                echo $this->getModuleOutput($module);
                $params = join(' ', $this->getParams());
                passthru($dir . 'phpunit -c ' . $path . ' ' . $params);
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

    protected function getTitle()
    {
        $console = $this->getConsole();

        // We prepend the usage by the module name (printed in red), so that each module is
        // clearly visible by the user
        $title = sprintf("%s\n%s\n%s\n",
            str_repeat('-', $console->getWidth()),
            "Humus PHPUnit Module for Zend Framework 2\n"
            . "Author: Sascha-Oliver Prolic",
            str_repeat('-', $console->getWidth())
        );

        return $console->colorize($title, ColorInterface::RED);
    }

    /**
     * Get a beautiful output
     * 
     * @param string $module
     * @return string
     */
    protected function getModuleOutput($module)
    {
        $console = $this->getConsole();

        $head = sprintf("%s\n%s\n%s\n",
            str_repeat('-', $console->getWidth()),
            'Testing Module: ' . $module,
            str_repeat('-', $console->getWidth())
        );

        return $console->colorize($head, ColorInterface::BLUE);
    }

    /**
     * @param Console $console
     */
    public function setConsole(Console $console)
    {
        $this->console = $console;
    }

    /**
     * @return Console
     */
    public function getConsole()
    {
        return $this->console;
    }

    public function setUsage($usage)
    {
        if (is_array($usage) && !empty($usage)) {
            $this->usage = $usage;
        } elseif (is_string($usage) && ($usage != '')) {
            $this->usage = array($usage);
        }
    }

    /**
     * @return mixed
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * Render a text table containing the data provided, that will fit inside console window's width.
     *
     * @param  $data
     * @param  $cols
     * @param  $consoleWidth
     * @return string
     */
    protected function renderTable($data, $cols, $consoleWidth)
    {
        $result  = '';
        $padding = 2;


        // If there is only 1 column, just concatenate it
        if ($cols == 1) {
            foreach ($data as $row) {
                $result .= $row[0] . "\n";
            }
            return $result;
        }

        // Get the string wrapper supporting UTF-8 character encoding
        $strWrapper = StringUtils::getWrapper('UTF-8');

        // Determine max width for each column
        $maxW = array();
        for ($x = 1; $x <= $cols; $x += 1) {
            $maxW[$x] = 0;
            foreach ($data as $row) {
                $maxW[$x] = max($maxW[$x], $strWrapper->strlen($row[$x-1]) + $padding * 2);
            }
        }

        /*
         * Check if the sum of x-1 columns fit inside console window width - 10
         * chars. If columns do not fit inside console window, then we'll just
         * concatenate them and output as is.
         */
        $width = 0;
        for ($x = 1; $x < $cols; $x += 1) {
            $width += $maxW[$x];
        }

        if ($width >= $consoleWidth - 10) {
            foreach ($data as $row) {
                $result .= implode("    ", $row) . "\n";
            }
            return $result;
        }

        /*
         * Use Zend\Text\Table to render the table.
         * The last column will use the remaining space in console window
         * (minus 1 character to prevent double wrapping at the edge of the
         * screen).
         */
        $maxW[$cols] = $consoleWidth - $width -1;
        $table       = new Table\Table();
        $table->setColumnWidths($maxW);
        $table->setDecorator(new Table\Decorator\Blank());
        $table->setPadding(2);

        foreach ($data as $row) {
            $table->appendRow($row);
        }

        return $table->render();
    }
}
