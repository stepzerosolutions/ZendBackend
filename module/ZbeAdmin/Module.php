<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZbeAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZbeAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use ZbeAdmin\Model\ZbeadminRoute;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

	/**
	 * get module.config.php data and assign local admin url controller details to module config
	 *
	 *
	 * @param load module.config.php and config/autoloadr/local.php
	 *
	 * @return module configuration details array
	 */
	public function getConfig(){
		$admin = new ZbeadminRoute();
		$config = include __DIR__ . '../../../config/autoload/local.php';
		
		$admincontroller_name = $admin->getAdminControllerBylocalConfig($config);
		
		if( !file_exists( __DIR__ . '../../../config/autoload/local.php') ||  !$admincontroller_name ){
			return include __DIR__ . '/config/module.config.php';
		}

		$moduleConfig = include __DIR__ . '/config/module.config.php';var_dump($moduleConfig);
		$adminModuleConfig = $admin->getModuleconfig($moduleConfig);
		$returnconfig = $admin->getchangedRouterConfig();
		return $returnconfig;
	}

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    
    public function init( ModuleManager $moduleManager){
        $sharedEvents=$moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e){
            $controller = $e->getTarget();
            $controller->layout('admin/layout');
        }, 100 );
    }
}
