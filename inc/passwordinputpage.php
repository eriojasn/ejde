<?php
    require("page.php");
    
    class PasswordInputPage extends Page 
    {
		public function Display()
		{			
			echo "<!DOCTYPE html>";
			echo "<html>\n<head>\n";
			$this -> DisplayTitle();
			$this -> DisplayKeywords();
			$this -> DisplayStyleFile();
			echo "</head>\n<body>\n";
			echo "<div id=\"wrapper\">";
			$this -> DisplayHeader();
			$this -> DisplayBody();
			$this -> DisplayFooter();
			echo "</div> <!-- end of wrapper -->";
			echo "</body>\n</html>\n";
		}

       	public function DisplayBody()
		{
			$db = $this->ConnectToDatabase();
			$listingId = $_GET["l"];
			$option = $_GET["o"];
			
            echo "<div id=\"bodycontent\">\n";
            
            $this->PullIndListing($db, $listingId, $location, $title, $date, $time, $description, $email, $password);
            
            if($option == 0)
            	echo "<h2>editar &gt<a href=\"".INDIVIDUAL_LISTING."?l=".$listingId."\">".$title."</a></h2>\n";
            else
            	echo "<h2>borrar &gt<a href=\"".INDIVIDUAL_LISTING."?l=".$listingId."\">".$title."</a></h2>\n";
            	
            echo "<div id=\"passwordform\">";
			$this -> DisplayPasswordForm($option, $listingId);
			echo "</div> <!-- end of passwordform div -->\n";
            echo "</div> <!-- end of bodycontent div -->\n";
        }
        
        public function DisplayPasswordForm($option, $listingId)
        {
        	if($option == 0)
        		echo "<form name=\"passwordform\" method=\"post\" action=\"".EDIT_LISTING."?l=".$listingId."\">";
        	else
        		echo "<form name=\"passwordform\" method=\"post\" action=\"".DELETE_LISTING."?l=".$listingId."\">";
        		
        	echo
    		"<label for=\"password\">contraseña</label><input type=\"text\" name=\"password\" style=\"width:8em;\" required/>
			<input type=\"submit\" value=\"ok\"/>
			</form>";
        }	
		
		public function DisplayHeader()
		{
			echo "<div id=\"header\">";
			echo "<div id=\"headercontent\">";
			$this->DisplayLogo();
			echo "</div><!-- end of headercontent div -->";
			echo "</div><!-- end of header div -->";
		}
    }
?>