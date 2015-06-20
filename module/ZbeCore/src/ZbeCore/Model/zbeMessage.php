<?php
namespace ZbeCore\Model;

use Zend\Session\Container;
/**
 *
 * @author Don Nuwinda
 *        
 */
 
class zbeMessage
{

    /**
     * Set success message.
     *
     * @param $message Message to display
     * @param $mode if true remove old messages
     * @return void
     */
    public function setSuccess($message, $mode=true){
        $success = new Container('success');
        $success->message = $mode ? $message : ($success->message) ? $success->message . $message:$message ;
    }
    
    
    /**
     * Set error message.
     *
     * @param $message Message to display
     * @param $mode if true remove old messages
     * @return void
     */
    public function setError($message, $mode=false){
        $error = new Container('error');
        $error->message = $mode ? $message : ($error->message) ? $error->message . $message:$message ;
    }
}