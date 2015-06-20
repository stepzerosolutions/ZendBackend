<?php
namespace ZbeCore\Model;

class LayoutxmlProcessor
{
    private $xmlLayoutPath;
    const DS = DIRECTORY_SEPARATOR;
    
    public function __construct(){
    }
    
    public function setXmlLayoutPath($path=NULL){
        return (empty($path))?"view".self::DS."assets".self::DS."layout":$path; 
    }
}