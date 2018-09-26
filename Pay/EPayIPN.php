<?php
/*
											* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
											*	ExtrinsicPay.com - IPN Example                          *
											*	(c) 2015 Extrinsic Studio, LLC - All Rights Reserved    *
											*	http://extrinsicpay.com                                 *
											* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/

/* Since we can use the same IPN for multiple Applications, set each application's security key by their app key ($Key => $Secret) */
$AppKeys = array(
					//Key from http://extrinsicpay.com			  //Secret from http://extrinsicpay.com
					'75df6d127e6c37b02c8e85832659195abbcc9de7' => '28baae92ad277ad602b873a67b10f6686d32cfbb',
				);
				
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* ExtrinsicPay IPNs will only be sent from IP Address 74.208.173.74, so let's check that for added security */

if ($_SERVER['REMOTE_ADDR'] != '74.208.173.74') {
	header('IPNResponse: Invalid IP Address'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 401 Unauthorized');
	exit;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* ExtrinsicPay will send a IPN Version HTTP Header: IPNVersion; lets make sure it's there and get it, and see if we can handle it */

if (!isset($_SERVER['HTTP_IPNVERSION'])) {
	header('IPNResponse: No IPN Version'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 400 Bad Request');
	exit;
}
$IPNRequestVersion = $_SERVER['HTTP_IPNVERSION'];

/* Since this code is for IPN version 1, we check to make sure the request is for version 1 */

if ($IPNRequestVersion != '1') {
	header('IPNResponse: Wrong IPN Version'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 501 Not Implemented');
	exit;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* ExtrinsicPay will send an Application Key in the HTTP Header AppKey; lets make sure it's there and get it */

if (!isset($_SERVER['HTTP_APPKEY'])) {
	header('IPNResponse: No AppKey'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 400 Bad Request');
	exit;
}
$AppKey = $_SERVER['HTTP_APPKEY'];

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* Now that we know which application is sending the request, we need to make sure we have a security key defined in $AppKeys, and store it */

if (!isset($AppKeys[$AppKey])) {
	header('IPNResponse: No Secret Key'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 400 Bad Request');
	exit;
}
$SecurityKey = $AppKeys[$AppKey];

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* Now we get the request query, remove the hash param, then use sha1($query . $secret) to verify the request authenticity */

$HashlessQueryString = substr(preg_replace('/(.*)(?|&)hash=[^&]+?(&)(.*)/i', '$1$2$4', $_SERVER['QUERY_STRING'] . '&'), 0, -1); 

if (sha1($HashlessQueryString . $SecurityKey) != $_GET['hash']) {
	header('IPNResponse: Hash Check Fail'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 401 Unauthorized');
	exit;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* All IPN Requests include at least 3 params: user (ID of the user who paid), price (amount they paid), and ip (IP address of the user) */

if (!isset($_GET['user']) || !isset($_GET['price']) || !isset($_GET['ip']) || !isset($_GET['trans'])) {
	header('IPNResponse: Invalid Params'); // Let ExtrinsicPay IPN Server know why the request failed
	header('HTTP/1.0 400 Bad Request');
	exit;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* Now that everything is verified, start doing your service-related funcstions */

$UserID = intval($_GET['user']);
$Price = intval($_GET['price']);
$IP = $_GET['ip'];
$TRANS = $_GET['trans'];

/* At this point, everything below this line until the next ~~~~~~ line can be completly edited to fit your needs. The following is all Pseudocode. */


/* DO SOMETHING HERE WITH THE ABOVE VALUES */


/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* The only thing left to do is let ExtrinsicPay know the request was successful */

header('IPNResponse: OK');
exit;
?>