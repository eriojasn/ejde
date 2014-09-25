<?php
	session_start();
	$_SESSION["realMessage"] = true;
	
    require("/home/eriojasn/inc/sendmessagepage.php");
    
    $contactPoster = new SendMessagePage();
    
    $contactPoster->Display();
?>