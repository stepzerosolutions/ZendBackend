<?php
namespace ZbeCore\Helper;

use Zend\Session\Container;
use Zend\View\Helper\AbstractHelper;
/**
 *
 * @author wasana
 *        
 */
class Error extends AbstractHelper
{
    protected $message;
    
    public function __invoke(){
        $error = new Container( 'error' );
        $message = $error->offsetGet('message');var_dump($message);
        $error->offsetUnset('message');
        return (!empty($message) ) ?'<div class="alert alert-danger"><small>' . $message . '</small></div>':'';
    }
}