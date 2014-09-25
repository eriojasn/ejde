<?php
    require("listingformpage.php");
    
    class EditListingPage extends ListingFormPage 
    {
       	public function DisplayBody()
		{
			echo "<div id=\"bodycontent\">\n";
			
			$db = $this->ConnectToDatabase();
			$listingId = $_GET["l"];
			$passwordProvided = $_POST["password"];
			
			$_POST["listingid"] = $listingId;

			$content = "<b>Vas a publicar un anuncio.</b> 
    		Si deseas que otra gente vea tu cuenta de correo electrónico, teléfono, ubicación o algún otro medio de contacto, inclúyelo en la descripción.<p>
    		</p>Porfavor sigue <a href=\"rules.php\">las reglas</a> y gracias por usar <b>el jardin de elias</b>!";
			
			$this->PullIndListing($db, $listingId, $location, $title, $date, $time, $description, $email, $password);
			
			if($passwordProvided == $password)
			{
				echo "<h2>editar</h2>"; 
				echo "<div id=\"lform\">";
				$this->DisplayForm($location, $title, $description, $email, $listingId);
				echo "</div> <!-- end of editform div -->\n";
			}
			else
			{
				$message = "<b><p>Contraseña incorrecta.</p></b> <a href=\"javascript:history.back()\">Regresar</a>";
				$this->DisplayError($message);
			}
			
            echo "</div> <!-- end of bodycontent div -->\n";
        }
    }
    
?>