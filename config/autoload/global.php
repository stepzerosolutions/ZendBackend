<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'global' => array (
		'theme' => 'default',
        'cache' => true,
        'clear_config_global' => true,      // has to be false for preformance reasons
        'theme_front' => 'default',
        'theme_admin' => 'zbe',
		'backend' => false,
		'page_title' => 'Zendbackend Project by StepZero',
		'log_message' => DIRECTORY_SEPARATOR .'data'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'message.log',
		'log_error' => DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'error.log'
    ),
	'service_manager' => array(
			'factory' => array(
					'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
			)
	) 
);
