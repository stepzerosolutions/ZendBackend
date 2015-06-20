<?php
namespace ZbeCore\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author wasana
 *        
 */
class SecureKey extends AbstractHelper
{
    public function __invoke($key="session") {
        return ( $key=="session") ? session_id() : md5( $key.session_id() );
    }
}
