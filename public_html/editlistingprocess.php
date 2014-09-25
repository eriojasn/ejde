<?php   
	session_start();
	$real = $_SESSION["realEditListing"];
	
    require("/home/eriojasn/inc/listingprocesspage.php");
    
    $test = new ListingProcessPage();

	if($real)
		$test->EditListing();
	else
		echo "no.";
		
	$_SESSION["realEditListing"] = false;
?>
