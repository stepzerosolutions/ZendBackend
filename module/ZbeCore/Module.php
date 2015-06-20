<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZbeCore for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZbeCore;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use ZbeCore\Model\Tables\ConfigurationTable;
use ZbeCore\Model\Tables\Configuration;

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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getServiceConfig(){
        return array(
            'factories' => array(
                'layoutManager' => 'ZbeCore\Service\LayoutFactory',
                'ConfigurationTable' => function($sm){
                    $tableGateway = $sm->get('ConfigurationGateway');
                    return new ConfigurationTable($tableGateway);
                },
                'ConfigurationGateway' => function($sm){
                    $config = $sm->get('config');
                    $adapter = new Adapter($config["production"]["db"]["params"]);
                    $resultSetPrototype = new ResultSet();
                    $configuration = new Configuration();
                    $resultSetPrototype->setArrayObjectPrototype( new Configuration() );
                    return new TableGateway($config["production"]["db"]["params"]["prefix"] . 'configuration', $adapter, null, $resultSetPrototype);
                },
            )
        );
    }
}
