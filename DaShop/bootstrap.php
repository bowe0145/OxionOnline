<?php
	#Security
	if( ! defined( 'IN_MALL' ) ) exit;
	
	#Debugging
	( $Config['DEBUG'] === true ) ? ini_set( 'display_errors' , true ) : ini_set( 'display_errors' , false );
	
	#Base includes
	require_once( $Config['INC'] . 'db.php' );
	
	require_once( $Config['INC'] . 'functions.php' );
	
	#Base variables
	$Database = new mssql( true );
	
	session_start();