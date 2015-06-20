<?php
namespace ZbeCore\Manager;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZbeCore\Interfaces\LayoutxmlProcessorInterface;
use Zend\ServiceManager\ServiceManager;
use ZbeCore\Model\LayoutxmlProcessor;

class LayoutManager extends LayoutxmlProcessor 
implements ServiceManagerAwareInterface, LayoutxmlProcessorInterface
{
    public function __construct(){
        parent::__construct();    
    }
    
    
    public function setServiceManager( ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;
    }
}