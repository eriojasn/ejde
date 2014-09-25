<?php
	session_start();
	$_SESSION["realDeleteListing"] = true;

    require("/home/eriojasn/inc/deletelistingpage.php");
    
    $deleteListingPage = new DeleteListingPage();
       
    $deleteListingPage->Display();
?>