<?php
	#Security
	if( ! defined( 'IN_MALL' ) ) exit;
	
	#Config variables
	$Config['DEBUG'] = true;
		
	$Config['DIR'] = getcwd() . "\\";		
	
	$Config['INC'] = $Config['DIR'] . "Inc\\";		
	
	$Config['MSSQL_HOST'] = 'NS514002\SQLEXPRESS';
	
	$Config['MSSQL_USER'] = 'sa';
	
	$Config['MSSQL_PASS'] = 'jg9744G9skwZKuy2WxKG';
	
	$Config['MSSQL_DB'] = 'Account';		
?>