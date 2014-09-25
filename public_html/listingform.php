<?php
	session_start();
	$_SESSION["realProcessListing"] = true;
			
    require("/home/eriojasn/inc/listingformpage.php");
    
    $listingForm = new ListingFormPage();
    
    $content = "<b>Vas a publicar un anuncio.</b> 
    		Si deseas que otra gente vea tu cuenta de correo electrónico, teléfono, ubicación o algún otro medio de contacto, inclúyelo en la descripción.<p>
    		</p>Gracias por usar <b>jardin de numa</b>!";
    
    $listingForm -> Display($content);
?>