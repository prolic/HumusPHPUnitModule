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

use HumusPHPUnitModule\RunnerInterface;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    /**
     * @var RunnerInterface
     */
    protected $runner;

    /**
     * @var array
     */
    protected $paramsToTest = array(
        array('modules'),
        array('stop-on-module-failure'),
        array('colors'),
        array('stderr'),
        array('stop-on-error'),
        array('stop-on-failure'),
        array('stop-on-skipped'),
        array('stop-on-incomplete'),
        array('strict'),
        array('verbose', 'v'),
        array('debug'),
        array('process-isolation'),
        array('no-globals-backup'),
        array('static-backup'),
        array('help', 'h'),
        array('version')
    );

    /**
     * Runs all tests and sets the exit code
     *
     * @return \Zend\Console\Response|\Zend\Stdlib\ResponseInterface
     */
    public function runAction()
    {
        $request = $this->getRequest();
        /* @var $request \Zend\Console\Request */

        $serviceParameters = array();

        foreach ($this->paramsToTest as $params) {
            foreach ($params as $param) {
                if ($result = $request->getParam($param)) {
                    $serviceParameters[$params[0]] = $result;
                    continue;
                }
            }
        }

        $runner = $this->runner;
        $runner->setParams($serviceParameters);
        $output = $runner->run();

        $response = $this->getResponse();
        /* @var $response \Zend\Console\Response */
        $response->setContent($output);
        $response->setErrorLevel($runner->getExitCode());
        return $response;
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
