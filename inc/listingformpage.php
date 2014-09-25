<?php
    require("page.php");
    
    class ListingFormPage extends Page
    {	 
   		public function DisplayBody($content)
		{
            echo "<div id=\"bodycontent\">\n";
            echo "<div id=\"lform\">";
			$this->DisplayAnnouncement($content);
			$this->DisplayForm();
			echo "</div> <!-- end of lform div -->\n";
            echo "</div> <!-- end of bodycontent div -->\n";
        }
        
        public function DisplayAnnouncement($content)
        {
        	echo "<div id=\"formnote\">";
        	echo $content;
        	echo "</div>";
        }
        
        public function DisplayForm($defaultLocation, $defaultTitle, $defaultDescription, $defaultEmail, $listingId)
        {
        	if($defaultLocation === null)
        		$defaultLocation = -1;
        	$categoryList = $this->BuildLocationList($defaultLocation);
        	
        	if($listingId)
        		echo "<form name=\"listingform\" method=\"post\" enctype=\"multipart/form-data\" action=\"".EDIT_LISTING_PROCESS."?l=".$listingId."\">";
        	else
        		echo "<form name=\"listingform\" method=\"post\" enctype=\"multipart/form-data\" action=\"".NEW_LISTING_PROCESS."\">";
        	
    		echo 
    		"<fieldset id=\"formfield\">
    		<legend style=\"font-weight:bold\">tu anuncio</legend>
    		<label for=\"listing_location\">categoría</label><select name=\"listing_location\" style=\"width:500px;\">".$categoryList."</select>
    		<label for=\"listing_title\">título*</label><input type=\"text\" name=\"listing_title\" value=\"".$defaultTitle."\" style=\"width:500px;\" required/>
			<label for=\"listing_description\">descripción</label><textarea style=\"width:500px; height: 200px;\" id=\"listing_description\" name=\"listing_description\">".$defaultDescription."</textarea>
			<label for=\"listing_email\">correo</label><input type=\"text\" name=\"listing_email\" value=\"".$defaultEmail."\" style=\"width:500px;\" pattern=\"[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}\"/>
			<label for=\"address\"></label><input type=\"text\" name=\"address\" style=\"display: none;\"/>
			<label for=\"file\">imágen</label><input type=\"file\" name=\"file\" id=\"file\">
			<div id=\"address\">
			<label for=\"listing_place\">lugar</label><input type=\"text\" name=\"listing_place\" style=\"width:500px;\"/>
			</div>
			<div class=\"buttonholder\">
			<input type=\"submit\" value=\"colocar anuncio\"/>
			</div>
			</fieldset>
			</form>";
        }	
	}
?>
    	

    	