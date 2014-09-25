<?php
    require("page.php");
    
    class AllListingsPage extends Page
    {   
        public $footerButtons = array(array("sobre nosotros", ABOUT_US)); //texto, liga
        
        public $listingsButtons = array(array("+ publicar anuncio", LISTING_FORM, 1)); //texto, liga, color
        
		public function Display($content)
		{
			//$db = $this->ConnectToDatabase();
			//$this->InsertTestListings($db, 100);
			
			echo "<!DOCTYPE html>";
			echo "<html>\n<head>\n";
			$this->DisplayTitle();
			$this->DisplayKeywords();
			$this->DisplayStyleFile();
			echo "</head>\n<body>\n";
			echo "<div id=\"wrapper\">";
			$this->DisplayHeader();
			$this->DisplayBody();
			$this->DisplayFooter();
			echo "</div> <!-- end of wrapper -->";
			echo "</body>\n</html>\n";
		}	
        
        public function DisplayBody()
		{	
            echo "<div id=\"bodycontent\">\n";
            echo "<div id=\"sidebar\">\n";
            for ($i = 0; $i<count($this->categories); $i++) {
                $this->DisplaySideButtons($this->categories[$i], $i);
            }
            echo "</div> <!-- end of sidebar div -->\n";
            $this->DisplayListingsArea();
            echo "</div> <!-- end of bodycontent div -->\n";
        }
        
        public function DisplaySideButtons($button, $cat) //displays sidebuttons and checks if current page and parents for formatting
        {
        	$db = $this->ConnectToDatabase();
        	$anch = $_SERVER['PHP_SELF']."?s=".$cat;
        	
        	$total = $this->CountCategoryListings($db, $cat);

            if ($button[2] == 1 && $this->IsURLCurrentPage($cat)) {
                echo "<div class=\"sidebuttoncat1\">&gt<a href=\"".$anch."\">".$button[0]."</a> <span class=\"numbercount\">".$total."</span></div>\n";
            }
            else if ($button[2] == 2 && $this->IsURLCurrentPage($cat)) {
                echo "<div class=\"sidebuttoncat2\">&gt<a href=\"".$anch."\">".$button[0]."</a> <span class=\"numbercount\">".$total."</span></div>\n";
            }
            else if ($button[2] == 1) {
                echo "<div class=\"sidebuttoncat1\"><a href=\"".$anch."\">".$button[0]."</a> <span class=\"numbercount\">".$total."</span></div>\n";
            }
            else {
                echo "<div class=\"sidebuttoncat2\"><a href=\"".$anch."\">".$button[0]."</a> <span class=\"numbercount\">".$total."</span></div>\n";
            }
        }
        
        public function DisplayListingsArea() //connect to database and pull the listings that are needed, then display
        {
        	$db = $this->ConnectToDatabase();
        	
        	$count = $_GET["c"];
        	$cat = $_GET["s"];
        	
        	if($cat === NULL || $cat == "")
        		$cat = -1;
        	
        	$this->PullListings($db, $count, $cat, $listingIds, $titles, $locations, $dates, $imageaddresses);
        	
            echo "<div id=\"listingsarea\">\n";
            
            for ($i = 0; $i<count($this->listingsButtons); $i++) {
                $this->DisplayListingsButton($this->listingsButtons[$i]);
            }
            
            $this->DisplayListings($listingIds, $titles, $locations, $dates, $imageaddresses);
            $this->DisplayListingsNav($db, $count, $cat);
            echo "</div> <!-- end of listingsarea div -->\n";
        }
        
        public function DisplayListingsButton($button)
        {
        	echo "<div id=\"addlistingbutton\"><a href=\"".$button[1]."\">".$button[0]."</a></div>\n";
        }
        
        public function DisplayListings($listingIds, $titles, $locations, $dates, $imageaddresses) 
        {
        	if(count($listingIds) > 0)
				for($i = 0; $i < count($listingIds); $i++) {
					echo "<div id=\"listingelement\">-<a href=\"".INDIVIDUAL_LISTING."?l=".$listingIds[$i]."\">".$titles[$i]."</a>&nbsp;";
					
					$this->DisplayListingSubtitle($dates[$i], $locations[$i], $imageaddresses[$i]);
					
					echo "</div>";
				}
			else
				echo "No hay nada aquí... :(";
        }
        
        public function DisplayListingsNav($db, $count, $cat)
        {			
        	$max = $this->MaxCount($db, $cat);	
        	$c = $count;
        	$p = $c-$this->listingsPerPage;
        	$n = $c+$this->listingsPerPage;
        	
        	if($cat == NULL)
        	{
        		$anchn = $_SERVER['PHP_SELF']."?c=".$n;
        		$anchp = $_SERVER['PHP_SELF']."?c=".$p;
        	}
        	else
        	{
        	    $anchn = $_SERVER['PHP_SELF']."?c=".$n."&s=".$cat;
        		$anchp = $_SERVER['PHP_SELF']."?c=".$p."&s=".$cat;
        	}
        	
        	if((!$c))
        	{
        		$c = 0;
        	}
        	
        	if(($c == 0) && ($this->listingsPerPage < $this->CountCategoryListings($db, $cat)))
        	{
            	echo "<div id=\"listingnav\"><a href=\"".$anchn."\">siguiente&gt;</a></div>\n";
            }
            else if($count > $max && ($this->listingsPerPage < $this->CountCategoryListings($db, $cat)))
            {
            	echo "<div id=\"listingnav\"><a href=\"".$anchp."\">&lt;anterior</a></div>\n";
            }
            else if(($this->listingsPerPage < $this->CountCategoryListings($db, $cat)))
            {
            	echo "<div id=\"listingnav\"><a href=\"".$anchp."\"> &lt;anterior </a>&nbsp;&nbsp;&nbsp;<a href=\"".$anchn."\">siguiente&gt;</a></div>\n";
            }
        }
        
        //returns object with the information that is going to be displayed in ListingsArea
        public function PullListings($db, $count, $cat, &$listingIds, &$titles, &$locationss, &$dates, &$imageaddresses)
        {
        	$i = 0;
        	$max = $this->MaxCount($db, $cat);
        	$subCats = $this->WhatAreItsSubCats($this->categories[$cat], $cat);
			$subCatsString = "";
			$to = $this->listingsPerPage;
			
			if ($count > $max)
			{
				$count = $max;
			}
			
			$locations = $this->BuildWhere($subCats);
			
			if(!$count)
			{
				$count = 0;
			}
	
			$stmt = $db->prepare("SELECT listingid, title, location, date, imageaddress 
					FROM listings
					WHERE location=".$locations."
					ORDER BY listingid DESC
					LIMIT ?,?");
			
			$stmt->bind_param('ii', $count, $to);

			if($stmt)
				$stmt->execute();
			else
				echo "Hubo un problema con la base de datos.";
			
			$stmt->bind_result($listingId, $title, $location, $date, $imageaddress);
				
			while($stmt->fetch()) {
				$listingIds[$i] = $listingId;
				$titles[$i] = $title;
				$locationss[$i] = $location;
				$dates[$i] = $date;
				$imageaddresses[$i] = $imageaddress;
				$i++;
			}
			
			$stmt->close();	
        }
        
        public function IsURLCurrentPage($i)
		{
			if($_GET["s"] == NULL)
			{
				return false;
			}
			else if(!($_GET["s"] == $i))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		public function MaxCount($db, $cat)
		{
			$total = $this->CountCategoryListings($db, $cat);
					
			$maxCount = $total - $this->listingsPerPage;
			
			return $maxCount;
		}
		
		public function BuildWhere($subCats) //returns information on WHERE PullListings should pull data from
		{
        	$locations = "";
			
			for($j = 0; $j < count($subCats); $j++)
        	{ 
        		$subCatsString = $subCats[$j];
        		
        		if($j != 0)
        		{
        			$locations = $locations."location = ".$subCatsString;
        		}
        		else
        		{
        			$locations = $locations.$subCatsString;
        		}
        		
        		if(!($j == count($subCats) - 1))
        		{
        			$locations = $locations." OR ";
        		}
        	}
        	
			return $locations;
		}
    }
?>