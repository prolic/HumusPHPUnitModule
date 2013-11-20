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

namespace HumusPHPUnitModuleTest\Controller;

use HumusPHPUnitModule\Controller\IndexController;
use Zend\Console\Request;
use Zend\Console\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\Parameters;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndexController
     */
    protected $controller;

    /**
     * @var Request
     */
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    public function setUp()
    {
        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index', 'action' => 'run'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testRunAction()
    {
        $runner = $this->getMockForAbstractClass('HumusPHPUnitModule\RunnerInterface');
        $runner
            ->expects($this->once())
            ->method('setParams')
            ->with(array(

            ));
        $runner
            ->expects($this->once())
            ->method('run');

        $this->controller->setRunner($runner);
        $response = new Response();
        $this->controller->dispatch($this->request, $response);
    }

    public function testRunActionWithParams()
    {
        $params = array(
            'strict' => true,
            'verbose' => true,
            'debug' => true
        );
        $runner = $this->getMockForAbstractClass('HumusPHPUnitModule\RunnerInterface');
        $runner
            ->expects($this->once())
            ->method('setParams')
            ->with($params);
        $runner
            ->expects($this->once())
            ->method('run');

        $params = new Parameters();
        $params->set('strict', true);
        $params->set('verbose', true);
        $params->set('debug', true);
        $this->request->setParams($params);

        $this->controller->setRunner($runner);
        $response = new Response();
        $this->controller->dispatch($this->request, $response);
    }
}
