<?php   
	session_start();
	$real = $_SESSION["realProcessListing"];
	
    require("/home/eriojasn/inc/listingprocesspage.php");
    
    $test = new ListingProcessPage();
	
	if($real)
		$test->InsertIntoDatabase();
	else
		echo "no.";
		
	$_SESSION["realProcessListing"] = false;
?>