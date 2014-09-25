<?php
	require("alllistingspage.php");
	
	class SearchResultsPage extends AllListingsPage 
	{
		public function DisplayBody()
		{	
			echo "<div id=\"bodycontent\">\n";
			$this->DisplayListingsArea();
			echo "</div> <!-- end of bodycontent div -->\n";
		}
		
		public function DisplayListingsArea()
		{
			$db = $this->ConnectToDatabase();
			
			$searchquery = $_GET["q"]; //q = search query
			$count = $_GET["c"];
			
			echo "<div id=\"searchlistingsarea\">\n";
			$this->DisplaySearchCount($db, $searchquery);
	
			$listingsObject = $this->PullListings($db, $searchquery, $listingIds, $titles, $locations, $dates);
			
			$this->DisplayListings($listingIds, $titles, $locations, $dates);
			$this->DisplayListingsNav($db, $count, $searchquery);
			echo "</div> <!-- end of listingsarea div -->\n";
		}
	
		public function DisplaySearchCount($db, $searchquery)
		{
			$count = $this->CountSearchListings($db, $searchquery);
			
			if($count != 1)
				echo "<div id=\"searchcount\">".$count." resultados...</div>\n";
			else
				echo "<div id=\"searchcount\">".$count." resultado...</div>\n";
		}
		
		public function DisplayListingsNav($db, $count, $searchquery)
        {			
        	$max = $this->MaxCount($db, $searchquery);	
        	$c = $count;
        	$p = $c - $this->listingsPerPage;
        	$n = $c + $this->listingsPerPage;
        	
        	if($searchquery == NULL)
        	{
        		$anchn = $_SERVER['PHP_SELF']."?c=".$n;
        		$anchp = $_SERVER['PHP_SELF']."?c=".$p;
        	}
        	else
        	{
        	    $anchn = $_SERVER['PHP_SELF']."?c=".$n."&q=".$searchquery;
        		$anchp = $_SERVER['PHP_SELF']."?c=".$p."&q=".$searchquery;
        	}
        	
        	if((!$c))
        	{
        		$c = 0;
        	}
        	
        	if(($c == 0) && ($this->listingsPerPage < $this->CountSearchListings($db, $searchquery)))
        	{
            	echo "<div id=\"listingnav\"><a href=\"".$anchn."\">sig&gt;</a></div>\n";
            }
            else if($count > $max && ($this->listingsPerPage < $this->CountSearchListings($db, $searchquery)))
            {
            	echo "<div id=\"listingnav\"><a href=\"".$anchp."\">&lt;prev</a></div>\n";
            }
            else if(($this->listingsPerPage < $this->CountSearchListings($db, $searchquery)))
            {
            	echo "<div id=\"listingnav\"><a href=\"".$anchp."\"> &lt;prev </a>&nbsp;&nbsp;&nbsp;<a href=\"".$anchn."\">sig&gt;</a></div>\n";
            }
        }
		
		public function PullListings($db, $searchquery, &$listingIds, &$titles, &$locationss, &$dates)
		{
			$i=0;
			$max = $this->MaxCount($db, $searchquery);
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
			
			$stmt = $db->prepare("SELECT listingid, title, location, date
					FROM listings
					WHERE MATCH (title, description)
					AGAINST(?)
					ORDER BY listingid DESC
					LIMIT ?,?");
					
			$stmt->bind_param('sii', $searchquery, $count, $to);

			if($stmt)
				$stmt->execute();
			else
				echo "Hubo un problema con la base de datos.";
			
			$stmt->bind_result($listingId, $title, $location, $date);
				
			while($stmt->fetch()) {
				$listingIds[$i] = $listingId;
				$titles[$i] = $title;
				$locationss[$i] = $location;
				$dates[$i] = $date;
				$i++;
			}

			$stmt->close();	
		}
	
		public function CountSearchListings($db, $searchquery)
		{
			$stmt = $db->prepare("SELECT * 
					FROM listings
					WHERE MATCH (title, description)
					AGAINST(?)");
					
			$stmt->bind_param('s', $searchquery);
					
			if($stmt)
				$stmt->execute();
			else
				echo "Hubo un problema con la base de datos.";
			
			$stmt->store_result();
			$total = $stmt->num_rows;
			
			$stmt->close();

			return $total;
		}
	
		public function MaxCount($db, $searchquery)
		{
			$total = $this->CountSearchListings($db, $searchquery);
				
			$maxCount = $total - $this->listingsPerPage;
		
			return $maxCount;
		}
	}
?>