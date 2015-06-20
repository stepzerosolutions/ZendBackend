<?php
namespace ZbeCore\Helper;

use Zend\Session\Container;
use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author wasana
 *        
 */
class Success extends AbstractHelper
{
    protected $message;
    
    public function __invoke(){
        $success = new Container ( 'success' );
        $message = $success->offsetGet('message');
        $success->offsetUnset('message');
        return (!empty($message) ) ?'<div class="alert alert-success">' . $message . '</div>':'';
    }
}