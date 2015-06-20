<?php
namespace ZbeAdmin\Model;

use ZbeAdmin\Interfaces\ZbeadminRouteInterface;
use ZbeAdmin\Exception\ErrorException;
/**
 *
 * @author Don Nuwinda
 *        
 */
class ZbeadminRouteManager implements ZbeadminRouteInterface
{
    /*
     * This will change admin router in module.config.php 
     * First it read system configuration 
     * Then change the admin router default is zbeadmin
     */
    public function changeRoute($route, $module_config){
       if( empty($route) ) throw new ErrorException("Can not found any admin route");
       $module_config["router"]["routes"]["zbeadmin"]["options"]["route"] = "/".$route;
       return $module_config;
    }
}
