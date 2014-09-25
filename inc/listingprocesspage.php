<?php
    require("page.php");
    
    class ListingProcessPage extends Page
    {
    	public function ResizeUploadedFile($imageSource)
    	{
    		$maxLength = 450;
    	
			$image = new Imagick($imageSource); 
			$dimensions = $image->getImageGeometry(); 
			$width = $dimensions['width']; 
			$height = $dimensions['height']; 
			$ratio = $width/$height;
			
			if($width > $height)
			{
				if($width > $maxLength)
				{	
					$width = $maxLength;
					$height = $maxLength / $ratio;
				}
			}
			else
			{
				if($height > $maxLength)
				{
					$height = $maxLength;
					$width = $maxLength * $ratio;
				}
			}
			
			$image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
			$image->writeImage($imageSource);
			
			$image->destroy();
			
			return $imageSource;
    	}
    
    	public function SaveUploadedFile(&$valid)
		{
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);

			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 1000000)
			&& in_array($extension, $allowedExts)) 
			{
			  if ($_FILES["file"]["error"] > 0) 
			  {
				/***
				echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
				***/
			
				$valid = FALSE;
			
				return $_FILES["file"]["error"];
			  } 
			  else 
			  {
				/***
				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
				***/
			
				if (file_exists("pic/" . $_FILES["file"]["name"])) 
				{
					/***
					echo $_FILES["file"]["name"] . " already exists. ";
					***/
				
					$valid = FALSE;
			
					return "Ya existe esa imágen.";
				} 
				elseif($valid) {	
					$resizedImage = $this->ResizeUploadedFile($_FILES["file"]["tmp_name"]);
				
					$typePieces = explode('/', $_FILES["file"]["type"]);
					$imageAddress = "pic/".$this->GeneratePassword(16).".".$typePieces[1];
				
					move_uploaded_file($resizedImage, $imageAddress);
				
					return $imageAddress;
			
					/*				
					$this->ResizeUploadedFile($_FILES["file"]["tmp_name"]);
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"pic/".$_FILES["file"]["name"]);
					*/
					/***
					echo "Stored in: " . "pic/" . $_FILES["file"]["name"];
					***/
				}
			  }
			} 
			else {
				/***
				echo "Invalid file";
				***/
			
				$valid = FALSE;
			
				return "Subiste un archivo que no es una imágen.";
			}
		}
    	
    	public function GeneratePassword($length)
    	{
    		if(!$length)
    			$length = 8;
    			
    		$password = "";
   			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		    for ($i = 0; $i < $length; $i++) 
		    {
        		$password = $password.$characters[rand(0, strlen($characters) - 1)];
        	}
        		
        	return $password;
    	}
    	
    	public function VerifyData($location, &$title, &$description, &$email, &$valid)
    	{
    		$errormessage = "";
    		
    		$errortitleforget = "Te faltó agregar un título.";
    		$errortitlelength = "Tu título está muy largo. (max: 70 car.)";
    		$errordescriptionlength = "Tu descripción está muy larga. (max: 100,000 car.)";
    		
    		$actualerror = "";

    		$valid = TRUE;
			
    		if (!$title)
    		{
    			$errormessage = $errormessage."<br>".$errortitleforget;
    			$valid = FALSE;
    		}
    		if (strlen($title) > 70)
    		{
    			$errormessage = $errormessage."<br>".$errortitlelength;
    			$valid = FALSE;
    		}
    		if (strlen($description) > 10000)
    		{
    			$errormessage = $errormessage."<br>".$errordescriptionlength;
    			$valid = FALSE;
    		}
    		
    		$errormessage = "<b>Error:</b>".$errormessage;
    		
    		return $errormessage;
    	}
    	
    	public function FormatData(&$title, &$description, &$email)
    	{
    		    $title = addslashes($title);
				$description = addslashes($description);
				$email = addslashes($email);
    	}
    	
    	public function InsertIntoDatabase()
    	{
    		$db = $this->ConnectToDatabase();
    		
    		$listingId = $_GET["l"];
    		
    		$location = $_POST["listing_location"];
    		$title = $_POST["listing_title"];
    		$description = $_POST["listing_description"];
    		$email = $_POST["listing_email"];
    		
    		$listingplace = $_POST["listing_place"];
    		
    		if($listingplace)
    		{
    			var_dump($listingplace);
    			die();
    		}
    		
    		$valid = FALSE;
    		$errormessage = $this->VerifyData($location, $title, $description, $email, $valid);
    		$content;
    		
    		if(file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) 
    		{
    			$response = $this->SaveUploadedFile($valid);
    			
    			if($valid)
    			{
    				$imageaddress = $response;
    			}
    			else
    			{
    				$errormessage = $errormessage."<br>".$response;
    			}
    		}
    		
    		$errormessage = $errormessage."<br><a href=\"javascript:history.back()\">Regresa</a> para modificar tu anuncio.";
						
    		if ($valid == FALSE)
    		{
    			$content = $errormessage;
    		}
    		else 
    		{
    			if($listingId === NULL)
    			{
					$password = $this->GeneratePassword();
				
					$stmt = $db->prepare("INSERT INTO listings
										VALUES (NULL, ?, ?, CURDATE(), CURTIME(), ?, ?, ?, ?)");
									
					$stmt->bind_param('isssss', $location, $title, $description, $email, $password, $imageaddress);
				
					if($stmt)
					{
						if($stmt->execute())
						{
							$listingid = $db->insert_id;
							$content = "<b>Tu anuncio ha sido publicado exitosamente!</b> La contraseña para tu anuncio es: ";
							$content = $content."<div style=\"text-align:center;\"><span style=\"color:black;\">".$password."</span></div></p>";
							$content = $content."Es necesaria para editar o borrar tu anuncio.";
							$content = $content." Puedes ver tu anuncio <a href=\"".INDIVIDUAL_LISTING."?l=".$listingid."\">aquí</a>.";
						}
						else 
						{
							$valid = FALSE;
							$content = "<p>Hubo un error con la base de datos. Favor de intentar más tarde.</p>";
						}
					}
					$stmt->close();
				}
				else
				{
					$this->FormatData($title, $description, $email);
    			
					$stmt = $db->prepare("UPDATE listings 
										SET title=?, location=?, description=?, email=?, imageaddress=?
										WHERE listingid=?");

					$stmt->bind_param('sisssi', $title, $location, $description, $email, $imageaddress, $listingId);
				
					if($stmt)
					{
						$stmt->execute();
						$content = "<b>Tu anuncio ha sido editado exitosamente!</b>";
						$content = $content." Puedes ver tu anuncio <a href=\"".INDIVIDUAL_LISTING."?l=".$listingId."\">aquí</a>.";
					}
					else
					{
						$valid = FALSE;
						$content = "<p>Hubo un error con la base de datos. Favor de intentar más tarde.</p>";
					}
					$stmt->close();
				}
    		}
    		
    		$this->Display($content, $valid);
    	}
    	
    	public function EditListing()
    	{
    	    $db = $this->ConnectToDatabase();

    	    $listingId = $_GET["l"];
    		
    		$location = $_POST["listing_location"];
    		$title = $_POST["listing_title"];
    		$description = $_POST["listing_description"];
    		$email = $_POST["listing_email"];
    		
    		$valid = FALSE;
    		$errormessage = $this->VerifyData($location, $title, $description, $email, $valid);
    		$content;
    		
    		if ($valid == FALSE)
    		{
    			$content = $errormessage;
    		}
    		else 
    		{
    			$this->FormatData($title, $description, $email);
    			
    			$stmt = $db->prepare("UPDATE listings 
    								SET title=?, location=?, description=?, email=?
    								WHERE listingid=?");

    			$stmt->bind_param('sissi', $title, $location, $description, $email, $listingId);
    			
    			if($stmt)
    			{
					$stmt->execute();
					$content = "<b>Tu anuncio ha sido editado exitosamente!</b>";
					$content = $content." Puedes ver tu anuncio <a href=\"".INDIVIDUAL_LISTING."?l=".$listingId."\">aquí</a>.";
				}
				else
				{
					$valid = FALSE;
					$content = "<p>Hubo un error con la base de datos. Favor de intentar más tarde.</p>";
				}
    		}
    		
    		$stmt->close();
    		$this->Display($content, $valid);
    	}
    	
    	public function Display($content, $valid)
		{
			echo "<!DOCTYPE html>";
			echo "<html>\n<head>\n";
			$this->DisplayTitle();
			$this->DisplayKeywords();
			$this->DisplayStyleFile();
			echo "</head>\n<body>\n";
			echo "<div id=\"wrapper\">";
			$this->DisplayHeader();
			if(!$valid)
			{
				$this->DisplayError($content);
			}
			else
			{
				$this->DisplaySuccess($content);
			}
			$this->DisplayFooter();
			echo "</div> <!-- end of wrapper -->";
			echo "</body>\n</html>\n";
		}
    }
?>  
    