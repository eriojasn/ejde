<?php   
	session_start();
	$real = $_SESSION["realMessage"];
	
    require("/home/eriojasn/inc/messageprocesspage.php");
    
    $test = new MessageProcessPage();
	
	if ($real)
		$test->SendMessage();
	else
		echo "no.";
		
	$_SESSION["realMessage"] = false;
?>