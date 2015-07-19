<?php
namespace ZbeAdmin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZbeAdmin\Manager\ZbeadminServicesManager;

class ZbeadminServicesFactory
implements FactoryInterface
{
    public function createService( ServiceLocatorInterface $serviceLocator){
        return new ZbeadminServicesManager($serviceLocator);
    }
}