<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=expense_manager',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',

	 // Enable parameter logging and profiling
    'enableParamLogging' => true,  // Enable parameter logging
    'enableProfiling' => true,     // Enable query profiling
	
);