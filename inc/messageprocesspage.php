<?php
    require("page.php");
    
    class MessageProcessPage extends Page
    {
    	public function Display($content, $valid)
		{
			echo "<!DOCTYPE html>";
			echo "<html>\n<head>\n";
			$this -> DisplayTitle();
			$this -> DisplayKeywords();
			$this -> DisplayStyleFile();
			echo "</head>\n<body>\n";
			echo "<div id=\"wrapper\">";
			$this -> DisplayHeader();
			if(!$valid)
			{
				$this -> DisplayError($content);
			}
			else
			{
				$this -> DisplaySuccess($content);
			}
			$this -> DisplayFooter();
			echo "</div> <!-- end of wrapper -->";
			echo "</body>\n</html>\n";
		}
		
		public function SendMessage()
		{
			$db = $this->ConnectToDatabase();
			
			$senderEmail = $_POST["email"];
			$subject = "";
			$message = "<p>".$_POST["message"]."</p>\n<div style=\"color:green;\">Para comunicarte con la persona que te está mandando este mensaje, solamente responde a este correo.</div>";
			$listingId = $_GET["l"];
			
			$listingplace = $_POST["listing_place"];
    		
    		if($listingplace)
    		{
    			die();
    		}
			
			$this->PullIndListing($db, $listingId, $location, $title, $date, $time, $description, $email, $password);
			
			$to      = $email;
			$subject = $subject.$title;
			$headers = 'From: mailer@jardindenuma.com' . "\r\n" .
				'Reply-To: '.$senderEmail.'' . "\r\n" .
				"MIME-Version: 1.0" . "\r\n" . 
               "Content-type: text/html; charset=UTF-8" . "\r\n";

			$mail = mail($to, $subject, $message, $headers);
			
			if($mail)
			{
				$content = "<b>Tu mensaje se ha enviado exitosamente!</b>";
				$valid = true;
			}
			else
			{
				$content = "<b>Hubo un error.</b> Favor de intentar más tarde.";
				$valid = false;
			}
			
			$this->Display($content, $valid);
		}
    }
?>  
    