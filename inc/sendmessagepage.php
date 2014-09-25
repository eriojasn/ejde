<?php
    require("listingformpage.php");
    
    class SendMessagePage extends ListingFormPage 
    {
       	public function DisplayBody()
		{
			echo "<div id=\"bodycontent\">\n";
			
			$db = $this->ConnectToDatabase();
			$listingId = $_GET["l"];
			
			$this->PullIndListing($db, $listingId, $location, $title, $date, $time, $description, $email, $password);

			echo "<h2>contactar &gt<a href=\"".INDIVIDUAL_LISTING."?l=".$listingId."\">".$title."</a></h2>\n"; 
			echo "<div id=\"editform\">";
			$this->DisplayForm($listingId);
			echo "</div> <!-- end of editform div -->\n";
			
            echo "</div> <!-- end of bodycontent div -->\n";
        }
        
        public function DisplayForm($listingId)
        {
    		echo "<form name=\"listingform\" method=\"post\" action=\"".MESSAGE_PROCESS."?l=".$listingId."\">
    			<fieldset id=\"contactfield\">
				<legend style=\"font-weight:bold\">tu mensaje</legend>
				<label for=\"email\">correo</label>
				<input type=\"text\" name=\"email\" style=\"width:300px;\" pattern=\"[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}\" required/>
				<label for=\"message\">mensaje</label>
				<textarea style=\"width:300px; height: 75px;\" id=\"message\" name=\"message\" required></textarea>	
				<div id=\"address\">
				<label for=\"listing_place\">lugar</label><input type=\"text\" name=\"listing_place\" value=\"".$defaultTitle."\" style=\"width:500px;\"/>
				</div>		
				<div class=\"buttonholder\">
				<input type=\"submit\" value=\"enviar mensaje\"/>
				</div>
				</fieldset>";
        }	
    }
    
?>