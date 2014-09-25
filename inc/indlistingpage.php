<?php
    require("page.php");
    
    class IndListingPage extends Page 
    {		
		public function DisplayBody()
		{
    		$listingid = $_GET["l"];
    		
    		if(!is_numeric($listingid))
    			die();
    		
    		$db = $this->ConnectToDatabase();
			
			$this->PullIndListing($db, $listingid, $location, $title, $date, $time, $description, $email, $password, $imageaddress);
			
			echo "<div id=\"bodycontent\">";
			echo "<div id=\"indlistingarea\">";
			$this->DisplayListingTitle($title, $listingid);
			echo "<div>";
			$this->DisplayListingSubTitle($date, $location);
			echo "</div>";
			if($description || $imageaddress)
				$this->DisplayListingOptions($email, $listingid);
			
			if($imageaddress)
				$this->DisplayListingImage($imageaddress);
				
			if($description)
				$this->DisplayListingDescription($description);
				
			$this->DisplayListingOptions($email, $listingid);
				
			echo "</div>";
			echo "</div> <!-- end of bodycontent div -->";
		}
	
		/*
		public function PullIndListing($db, $listingid)
		{									
			$q = "SELECT * 
					FROM listings
					WHERE listingid=".$listingid;
		
			$listingObject = $db->query($q);
			$l = $listingObject->fetch_row();
				
			return $l;	
		} */
	
		public function DisplayListingTitle($listingTitle, $listingid)
		{
			echo "<h2><a href=\"".INDIVIDUAL_LISTING."?l=".$listingid."\">".$listingTitle."</a></h2>\n";
		}
		
		public function DisplayListingImage($imageaddress)
		{
			echo "<br><img src=\"".$imageaddress."\" alt=\"".$imageaddress."\"><br>";
		}
	
		public function DisplayListingDescription($listingDescription)
		{
			echo "<p style=\"color:black;\">".$listingDescription."</p>";
		}
		
		public function DisplayListingOptions($email, $listingId)
        {			
            echo "<span class=\"options\"><a href=\"".PASSWORD_INPUT."?l=".$listingId."&o=0\">editar</a></span>\n";
            echo "·&nbsp;";
            echo "<span class=\"options\"><a href=\"".PASSWORD_INPUT."?l=".$listingId."&o=1\">borrar</a></span>\n";
            
            if($email)
            {
            	echo "·&nbsp;";
            	echo "<span class=\"optionsS\"><a href=\"".SEND_MESSAGE."?l=".$listingId."\" target=\"_blank\">contactar</a></span>\n";
            }
        }
	
		public function DisplayContactBox()
		{
			echo "<fieldset id=\"contactfield\">
				<legend style=\"font-weight:bold\">contactar</legend>
				<label for=\"listing_email\">tu correo : </label><input type=\"text\" name=\"listing_email\" style=\"width:300px;\" />
				<label for=\"listing_description\">mensaje : </label><textarea style=\"width:300px; height: 75px;\" id=\"listing_description\" name=\"listing_description\"></textarea>			<div class=\"buttonholder\">
				<input type=\"submit\" value=\"enviar mensaje\"/>
				</div>
				</fieldset>";
		}
	}
?>