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
