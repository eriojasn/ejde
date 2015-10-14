<?php
    require("passwordinputpage.php");
    
    class DeleteListingPage extends Page 
    {
       	public function DisplayBody()
	{
			$db = $this->ConnectToDatabase();
			$listingId = $_GET["l"];
			$passwordProvided = $_POST["password"];
			
			$this->PullIndListing($db, $listingId, $location, $title, $date, $time, $description, $email, $password);
			
			if($passwordProvided == $password)
			{
				$numberDeleted = $this->DeleteIndListing($db, $listingId);
				
				if($numberDeleted == 1)
				{
					$message = "Se ha borrado <b>".$numberDeleted."</b> anuncio de la base de datos.";
					$this->DisplaySuccess($message);
				}
				else
				{
					$message = "Se han borrado <b>".$numberDeleted."</b> anuncios de la base de datos. <a href=\"javascript:history.back()\">Regresar</a>";
					$this->DisplayError($message);
				}
			}
			else
			{
				$message = "<b><p>Contraseña incorrecta.</p></b> <a href=\"javascript:history.back()\">Regresar</a>";
				$this->DisplayError($message);
			}
        }
        
        public function DeleteIndListing($db, $listingId)
        {        
        	$stmt = $db->prepare("DELETE
        	FROM listings
        	WHERE listingid=?
        	LIMIT 1");
        	
        	$stmt->bind_param('i', $listingId);
        	
        	if($stmt)
				$stmt->execute();
			else
				echo "Hubo un problema con la base de datos.";
				
			$numberDeleted = $stmt->affected_rows;
			
			$stmt->close();	
			
			return $numberDeleted;
        }
    }
    
?>
