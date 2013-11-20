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
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\LocatorRegisteredInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, LocatorRegisteredInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console)
    {
        return array(
            // Describe available commands
            'humusphpunit [switches]'    => 'runs humusphpunit',

            // Describe expected parameters
            array(
                '--modules=<comma separated list of modules>',
                'Specify modules to test, e.g. --modules=Foo,Bar,Baz will only test these three modules'
            ),
            array(
                '--stop-on-module-failure',
                'Stop execution upon first failed module test suite.'
            ),
            array(
                '--colors',
                'Use colors in output.'
            ),
            array(
                '--stderr',
                'Write to STDERR instead of STDOUT.'
            ),
            array(
                '--stop-on-error',
                'Stop execution upon first error.'
            ),
            array(
                '--stop-on-failure',
                'Stop execution upon first error or failure.'
            ),
            array(
                '--stop-on-skipped',
                'Stop execution upon first skipped test.'
            ),
            array(
                '--stop-on-incomplete',
                'Stop execution upon first incomplete test.'
            ),
            array(
                '--strict',
                'Run tests in strict mode.'
            ),
            array(
                '--verbose|-v',
                'Output more verbose information.'
            ),
            array(
                '--debug',
                'Display debugging information during test execution.'
            ),
            array(
                '--process-isolation',
                'Run each test in a separate PHP process.'
            ),
            array(
                '--no-globals-backup',
                'Do not backup and restore $GLOBALS for each test.'
            ),
            array(
                '--static-backup',
                'Backup and restore static attributes for each test.'
            ),
            array(
                '--help|-h',
                'Prints thhe usage information.'
            ),
            array(
                '--version',
                'Prints the version and exits.'
            ),
        );
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );

    }
}
