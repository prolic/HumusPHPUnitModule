namespace HumusPHPUnitModuleTest;

use PHPUnit_Framework_TestCase as BaseTestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

/**
 * Base test case to be used when a service manager instance is required
 */
class ServiceManagerTestCase extends BaseTestCase
{
    /**
     * @var array
     */
    private static $configuration = array();

    /**
     * @static
     * @param array $configuration
     */
    public static function setServiceManagerConfiguration(array $configuration)
    {
        static::$configuration = $configuration;
    }

    /**
     * @static
     * @return array
     */
    public static function getServiceManagerConfiguration()
    {
        return static::$configuration;
    }

    /**
     * Retrieves a new ServiceManager instance
     *
     * @param  array|null     $configuration
     * @return ServiceManager
     */
    public function getServiceManager(array $configuration = null)
    {
        $configuration = $configuration ?: static::getServiceManagerConfiguration();
        $serviceManager = new ServiceManager(new ServiceManagerConfig($configuration));
        $serviceManager->setService('ApplicationConfiguration', $configuration);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
        /* @var $moduleManager \Zend\ModuleManager\ModuleManagerInterface */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        return $serviceManager;
    }
}
