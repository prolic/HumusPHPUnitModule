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

use HumusMvc\Service\ServiceManagerConfig as HumusServiceManagerConfig;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

chdir(__DIR__ . '/../../../../');

include 'init_autoloader.php';

// init the application
$configuration = include 'config/application.config.php';
$smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();

if (class_exists('HumusMvc\Service\ServiceManagerConfig')) {
    $config = new HumusServiceManagerConfig($smConfig);
    // only useful with HumusMvc
} else {
    // use zf2 with zf2 skeleton app
    $config = new ServiceManagerConfig($smConfig);
}
$serviceManager = new ServiceManager($config);
$serviceManager->setService('ApplicationConfig', $configuration);

$serviceManager->get('ModuleManager')->loadModules();
$serviceManager->get('Application')->bootstrap();

// run all tests
$runner = $serviceManager->get('HumusPHPUnitRunner');
$runner->run();
