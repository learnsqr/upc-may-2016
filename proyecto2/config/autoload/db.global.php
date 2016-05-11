<?php

return array(
		'db' => array(
				// for primary db adapter that called
				// by $sm->get('Zend\Db\Adapter\Adapter')
				'driver'    => 'Pdo',
				'driver_options'  => array(
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
				),
				'dsn'       => 'mysql:dbname=zf2;host=localhost',
				'database'  => 'zf2',
				'username'  => 'root',
				'password'  => '',
				'hostname'  => 'localhost',
				 
				// to allow other adapter to be called by
				// $sm->get('dbMasterAdapter') or $sm->get('dbSlaveAdapter') based on the adapters config.
				'adapters' => array(
						'dbMasterAdapter' => array(
								'driver'         => 'Pdo',
								'driver_options'  => array(
										PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
								),
								'dsn'       => 'mysql:dbname=zf2;host=localhost',
								'database'  => 'zf2',
								'username'  => 'root',
								'password'  => '',
								'hostname'  => 'localhost',
						),
						
						'dbSlaveAdapter' => array(
								'driver'         => 'Pdo',
								'driver_options'  => array(
										PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
								),
								'dsn'       => 'mysql:dbname=zf2;host=localhost',
								'database'  => 'zf2',
								'username'  => 'root',
								'password'  => '',
								'hostname'  => 'localhost',
						),						
				),
		),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
);