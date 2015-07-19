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
use Zend\Mvc\MvcEvent;
use ZbeAdmin\Model\ZbeadminRouteManager;
use Zend\Db\Adapter\Adapter;
use ZbeAdmin\Model\Tables\Administrator;
use ZbeAdmin\Model\Tables\AdministratorTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


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
	    $config = include __DIR__ . '../../../config/autoload/local.php';
	    $module_config = include __DIR__ . '/config/module.config.php';
	    if( isset($config["production"]["admin_dir"]) && !empty($config["production"]["admin_dir"]) ) {
		  $adminRouteManager = new ZbeadminRouteManager();
		  $abs = $adminRouteManager->changeRoute($config["production"]["admin_dir"], $module_config );//var_dump($abs["router"]["routes"]);
		  return $abs;
	    }
        return $module_config; 
	}

    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        $app->getEventManager()->attach('render', array($this, 'processAdminServices'));
    }
    

    /**
     * Process Administrator services Locad admin theme.
     * Modules can load admin theme by loading adminthemeServices 
     */
    public function processAdminServices(MvcEvent $event){
        $routeMatch = $event->getRouteMatch();
        if( $routeMatch ) {
            $controller = strtolower(  $routeMatch->getParam( 'controller' ) );
            if( $controller==="zbeadmin" ){
                $serviceManager = $event->getApplication()->getServiceManager();
                $adminthemeServices = $serviceManager->get('adminthemeServices');
                $adminthemeServices->setAdminTheme();
            }
        }
    }

    
    public function getServiceConfig(){
        return array(
            'factories' => array(
                'adminthemeServices' => 'ZbeAdmin\Service\ZbeadminServicesFactory',
                'AdministratorTable' => function($sm){
                    $tableGateway = $sm->get('AdministratorGateway');
                    return new AdministratorTable($tableGateway);
                },
                'AdministratorGateway' => function($sm){
                    //$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $config = $sm->get('config');
                    $adapter = new Adapter($config["production"]["db"]["params"]);
                    $resultSetPrototype = new ResultSet();
                    $administrator = new Administrator();
                    $resultSetPrototype->setArrayObjectPrototype( new Administrator() );
                    return new TableGateway($config["production"]["db"]["params"]["prefix"] . 'administrator', $adapter, null, $resultSetPrototype);
                },
                'DbAdapter' => function($sm){
                    $config = $sm->get('config');
                    $adapter = new Adapter($config["production"]["db"]["params"]);
                    return $adapter;
                },
            )
        );
    }
}
