<?php  
	error_reporting(0);
	$conn = mysql_connect('localhost', 'root', '');
	 if (!$conn)
    {
	 die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("vpn_ssl_app", $conn);
?>