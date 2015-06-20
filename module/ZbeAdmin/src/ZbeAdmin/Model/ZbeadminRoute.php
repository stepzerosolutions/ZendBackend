<?php
namespace ZbeAdmin\Model;

/*
*   DEPRECATED CLASS
*   
*   */

use Zend\Mvc\MvcEvent;
/**
 *
 * @author Don Udugala
 * This class is deprecated
 *        
 */
class ZbeadminRoute
{
    protected $config;
    protected $moduleConfig;
   
    /**
     * return admin url once event manager is load
     *
     * @param MvcEvent $e
     *
     * @return admin url
     */
    public function getAdminController( MvcEvent $e ){
        $config = $e->getParam('application')->getConfig();
        if( !$config['production'] ){
            return false;
        }
        $this->config = $config;
        return $config['production']['admin_dir'];
    }
    
    /**
     * return module config data
     *
     * @param module.config.php $module_config
     *
     * @return boolean
     */
    public function getModuleconfig($module_config){
        $this->moduleConfig = $module_config;
        if( !$this->moduleConfig['router'] ){
            return false;
        }
        return true;
    }
    
    
    /**
     * return admin controller by local config file
     *
     * @param config/autoload local configuration $config
     *
     * @return new admin url controller
     */
    public function getAdminControllerBylocalConfig($config){
        $this->config = $config;
        if(!$config['production']['admin_dir']){
            return false;
        }
        return $config['production']['admin_dir'];
    }
    
    
    /**
     * change module.config.php configuration details
     *
     * change controllers->invokables to our new admin controller
     * change routers details to our new controller
     *
     * @param
     *
     * @return module configuration details array
     */
    public function getchangedRouterConfig(){
        $return = null;
        if( !$this->moduleConfig['router']){
            return false;
        }
        	
        $controller = ucfirst($this->config['production']['admin_dir']);
        $this->moduleConfig['controllers']["invokables"][$controller.'\Controller\Admin'] = 'ZbeAdmin\Controller\AdminController';
        $this->moduleConfig['router']["routes"][$this->config['production']['admin_dir']] = $this->moduleConfig['router']["routes"]["zbeadmin"];
        $this->moduleConfig['router']["routes"][$this->config['production']['admin_dir']]["options"]["route"] = '/'.$this->config['production']['admin_dir'];
        $this->moduleConfig['router']["routes"][$this->config['production']['admin_dir']]["options"]["defaults"]["action"] = 'index';
        	
        if( isset($this->moduleConfig['navigation']["admin_topnavigation"]) ){
            foreach( $this->moduleConfig['navigation']["admin_topnavigation"] as $key => $value ):
            if( $this->moduleConfig['navigation']["admin_topnavigation"][$key]["route"]=="zbeadmin" ){
                $return = $this->multidementionArrayLookup($this->moduleConfig['navigation']["admin_topnavigation"], "route", "zbeadmin", $this->config['production']['admin_dir'], "pages" );
            }
            endforeach;
        }
        return $this->moduleConfig;
    }
    
    
    
    
    /**
     * Function multidementionArrayLookup
     * change change admin module name to local configuration value
     *
     *
     * @param $array Main array to look
     * @param $searchIn First level search
     * @param $lookfor Search for this value
     * @param $replace If $lookfor item exsits replace it
     * @param $searchKey look for next level
     *
     *
     * @return $array array of module configuration values
     */
    public function multidementionArrayLookup($array, $searchIn, $lookfor, $replace, $searchKey="pages" ){
        foreach( $array as $key => $value ):
        if(  $array[$key][$searchIn]==$lookfor ){
            $array[$key][$searchIn] = $replace;
        }
    
        if( array_key_exists( $searchKey, $array[$key][$searchIn] ) ){
            $this->multidementionArrayLookup( $array[$key][$searchIn][$searchKey] , $searchIn, $lookfor, $replace, $searchKey );
        }
        endforeach;
        return $array;
    }
}