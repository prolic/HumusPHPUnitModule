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

namespace HumusPHPUnitModule\Controller;

use HumusPHPUnitModule\Module;
use HumusPHPUnitModule\Runner;
use HumusPHPUnitModule\RunnerInterface;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\Console\Request as ConsoleRequest;

class IndexController extends AbstractActionController
{
    /**
     * @var RunnerInterface
     */
    protected $runner;

    public function runAction()
    {
        $request = $this->getRequest();

        $strict  = $request->getParam('strict');
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $debug   = $request->getParam('debug');
        $help    = $request->getParam('help') || $request->getParam('h');
        $version = $request->getParam('version');

        $params = array();
        if ($strict) {
            $params[] = '--strict';
        }
        if ($verbose) {
            $params[] = '--verbose';
        }
        if ($debug) {
            $params[] = '--debug';
        }
        if ($help) {
            $params[] = '--help';
        }
        if ($version) {
            $params[] = '--version';
        }


        $runner = $this->runner;
        $runner->setParams($params);
        $runner->run();
    }

    /**
     * Set runner
     *
     * @param RunnerInterface $runner
     */
    public function setRunner(RunnerInterface $runner)
    {
        $this->runner = $runner;
    }
}
