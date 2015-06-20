<?php
Namespace ZbeCore\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZbeCore\Manager\LayoutManager;


Class LayoutFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator){
        $config = $serviceLocator->get('configuration'); 
        $layoutManager = new LayoutManager();
        return $layoutManager;  
    }
}