<?php
namespace ZbeAdmin\Manager;

use ZbeAdmin\Interfaces\ZbeadminThemeSelectInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;

class ZbeadminServicesManager
implements ZbeadminThemeSelectInterface
{
    //Servicelocator Instance
    public $serviceLocator;
    
    //Servicelocator Instance
    public $session;
    
    
   public function __construct( ServiceLocatorInterface $serviceLocator ){
       $this->serviceLocator = $serviceLocator;
   } 
   
   public function getAdminTheme(){
       $config  = $this->serviceLocator->get('config');
       return $config["global"]["theme_admin"];
   }
   
   public function setAdminTheme(){
       $this->session = new Container('application_session');
       $config  = $this->serviceLocator->get('config');
       $this->session->theme = $config["global"]['theme_admin'];
   }
   
   
}