<?php
	#Seccczzz
	define( 'IN_MALL' , true );
	
	define( 'EMAIL' , 'tawfiq11@hotmail.com' );
	
	logg('payment received');
	logg($_POST['custom']);
	
	$amount = 1000;

	$raw_post_data = file_get_contents('php://input');
	
	$raw_post_array = explode('&', $raw_post_data);
	
	$myPost = array();
	
	foreach ($raw_post_array as $keyval) 
	{
	  $keyval = explode ('=', $keyval);
	  
		if (count($keyval) == 2)
		{
			$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
	}

	$req = 'cmd=_notify-validate';
	
	if(function_exists('get_magic_quotes_gpc'))
	{
	   $get_magic_quotes_exists = true;
	} 
	
	foreach ($myPost as $key => $value) 
	{        
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
		{ 
			$value = urlencode(stripslashes($value)); 
		} 
		else 
		{
			$value = urlencode($value);
		}

		$req .= "&$key=$value";
	}
	 
	// STEP 2: Post IPN data back to paypal to validate
	 
	$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
	
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	
	curl_setopt($ch, CURLOPT_POST, 1);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	
	curl_setopt ($ch, CURLOPT_CAINFO, "cacert.pem");
	 
	if( !($res = curl_exec($ch)) ) 
	{
		curl_close($ch);
		
		exit;
	}
	
	curl_close($ch);
	
	if (strcmp ($res, "VERIFIED") == 0) 
	{
		$payment_status = $_POST['payment_status'];
		
		$payment_amount = $_POST['mc_gross'];
		
		$payment_currency = $_POST['mc_currency'];
		
		$txn_id = $_POST['txn_id'];
		
		$receiver_email = $_POST['receiver_email'];
		
		$payer_email = $_POST['payer_email'];

		if( $payment_status != 'Completed' )
		{
			logg("status not completed"); exit;
		}
		elseif( ! isset( $_POST['custom'] ) )
		{
			logg("custom not set"); exit;
		}
		elseif( ! is_numeric( $_POST['custom'] ) || ! is_numeric( $_POST['mc_gross'] ) )
		{
			logg("custom numeric"); exit;
		}
		elseif( $payment_currency != 'USD' )
		{
			logg("currency"); exit;
		}
		elseif( $receiver_email != EMAIL )
		{
			logg("email"); exit;
		}
		else
		{
			require_once( 'config.php' );

			require_once( $Config['INC'] . 'db.php' );

			require_once( $Config['INC'] . 'functions.php' );
		
			$Database = new mssql( true );

			if($payment_amount == '5')
			{
				functions::AddPoints( $_POST['custom'], 5000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 5, 5000);
			}
			elseif($payment_amount == '10')
			{
				functions::AddPoints( $_POST['custom'], 11000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 10, 11000);
			}
			elseif($payment_amount == '15')
			{
				functions::AddPoints( $_POST['custom'], 16500 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 15, 16500);
			}
			elseif($payment_amount == '20')
			{
				functions::AddPoints( $_POST['custom'], 22000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 20, 22000);
			}
			elseif($payment_amount == '25')
			{
				functions::AddPoints( $_POST['custom'], 27500 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 25, 27500);
			}			
			elseif($payment_amount == '30')
			{
				functions::AddPoints( $_POST['custom'], 34000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 30, 34000);
			}
			elseif($payment_amount == '35')
			{
				functions::AddPoints( $_POST['custom'], 40000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 35, 40000);
			}
			elseif($payment_amount == '40')
			{
				functions::AddPoints( $_POST['custom'], 45000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 40, 45000);
			}
			elseif($payment_amount == '45')
			{
				functions::AddPoints( $_POST['custom'], 55000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 45, 55000);
			}
			elseif($payment_amount == '50')
			{
				functions::AddPoints( $_POST['custom'], 60000 );
				functions::AddLog( $_POST['custom'], $payer_email, $txn_id, 50, 60000);
			}
		}
	} 
	else if (strcmp ($res, "INVALID") == 0) 
	{

	}
	
	function logg( $text )
	{
		$file = 'test.txt';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= $text . "\r\n";
		// Write the contents back to the file
		file_put_contents($file, $current);
	}
?>