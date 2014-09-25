<?php
	session_start();
	$_SESSION["realProcessListing"] = true;

    require("/home/eriojasn/inc/editlistingpage.php");
    
    $editListingPage = new EditListingPage();
       
    $editListingPage->Display();
?>