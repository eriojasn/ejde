<?php   
	session_start();
	$real = $_SESSION["realNewListing"];
	
    require("/home/eriojasn/inc/listingprocesspage.php");
    
    $test = new ListingProcessPage();
	
	if ($real)
		$test -> InsertIntoDatabase();
	else
		echo "no.";
		
	$_SESSION["realNewListing"] = false;
?>