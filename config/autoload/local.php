<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
	   'production' => array(
	         'webhost' => 'localhost',
			 'admin_dir' => 'bspecad',
			 'encription_key' => '6c20eca6d595a5f485976fd7063a4b75',
				'db' => array(
						'params' =>
						array (
								'driver' => 'Mysqli',
								'host' => 'localhost',
								'username' => 'root',
								'password' => '',
								'dbname' => 'zbe',
								'prefix' => 'zbe_',
						),
				),
		)
);