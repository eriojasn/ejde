<?php
header ('Content-type: text/html; charset=utf-8');

//anchors
define("LOGO", "img/logo.png");
define("CSS_FILE", "/style.css");
define("HOME", "/");
define("INDIVIDUAL_LISTING", "/individuallisting.php");
define("PASSWORD_INPUT", "/passwordinput.php");
define("EDIT_LISTING", "/editlisting.php");
define("DELETE_LISTING", "/deletelisting.php");
define("SEND_MESSAGE", "/sendmessage.php");
define("LISTING_FORM", "/listingform.php");
define("NEW_LISTING_PROCESS", "/listingprocess.php");
define("EDIT_LISTING_PROCESS", "/listingprocess.php");
define("MESSAGE_PROCESS", "/messageprocess.php");
define("SEARCH_RESULTS", "/searchresults.php");

//database credentials
define("DB_HOST", "");
define("DB_USERNAME", "");
define("DB_PASSWORD", "");
define("DB", "");

class Page 
{	
	// class Page's attributes
	public $title = "jardin de numa - compra y venta en Monterrey";
	public $keywords = "compra venta mercado libros electronicos clasificados";
	public $styleFile = CSS_FILE;
	
	public $listingsPerPage = 50;

	public $categories = array( 		array("vehículos", "",1),
                                        array("automóviles", "",2),
                                        array("camionetas", "",2),
                                        array("pickups", "",2),
                                        array("camiones", "",2),
                                        array("motocicletas", "",2),
                                        array("acuáticos", "",2),
                                        array("maquínaria", "",2),
                                        array("accesorios", "",2),
                                        array("refacciones", "",2),
                                        array("electrónicos", "",1),
                                        array("celulares", "",2),
                                        array("videojuegos", "",2),
                                        array("computadoras y laptops", "",2),
                                        array("tablets", "",2),
                                        array("cámaras", "",2),
                                        array("inmuebles", "",1),
                                        array("casas", "",2),
                                        array("departamentos", "",2),
                                        array("cuartos", "",2),
                                        array("terrenos", "",2),
                                        array("oficinas", "",2),
                                        array("roommates", "",2),
                                        array("artículos del hogar", "",1),
                                        array("mascotas", "",1),
                                        array("perros", "",2),
                                     	array("gatos", "",2),
                                     	array("de granja", "",2),
                                     	array("aves", "",2),
                                     	array("accesorios", "",2),
                                     	array("útiles escolares","",1),
                                     	array("libros y películas", "", 1),
                                     	array("novelas", "",2),
                                     	array("revistas y comics", "",2),
                                     	array("libros de texto", "",2),
                                     	array("dvds y bluray", "",2),
                                     	array("ropa y accesorios", "",1),
                                     	array("relojes y joyas", "",1),
                                     	array("instrumentos", "",1),
                                     	array("boletos", "",1),
                                     	array("juguetes", "",1),
                                     	array("empleos", "", 1),
                                     	array("profesionistas", "", 2),
                                     	array("técnicos", "", 2),
                                     	array("secretarias", "", 2),
                                     	array("domésticos", "", 2),
                                     	array("operadores", "", 2),
                                     	array("auxiliares", "", 2),
                                     	array("seguridad", "", 2),
                                     	array("choferes", "", 2),
                                     	array("enfermeras", "", 2),
                                     	array("salud y belleza", "", 2),
                                     	array("vendedores", "", 2),
                                     	array("chefs", "", 2),
                                     	array("etc", "", 2),
                                     	array("servicios", "", 1),
                                     	array("del hogar", "", 2),
                                     	array("belleza", "",2),
                                     	array("computadora", "",2),
                                     	array("mecánica", "",2),
                                     	array("jardín y alberca", "",2),
                                     	array("mudanza", "",2),
                                     	array("eventos", "",2),
                                     	array("legal", "",2),
                                     	array("arquítectos", "", 2),
                                     	array("clases y tutores", "",2),
                                     	array("seguridad", "", 2),
                                     	array("eventos", "",1),
                                     	array("banquetes", "",2),
                                     	array("ambientación", "",2),
                                     	array("flores", "",2),
                                     	array("juegos", "",2),
                                     	array("música y karaoke", "",2),
                                     	array("salones", "",2)
            ); //nombre, liga, categoria (1 mas alta)
	
	//class Page's methods
	public function __set($name, $value)
	{
		$this -> $name = $value;
	}
	
	public function Display($content)
	{
		echo "<!DOCTYPE html>";
		echo "<html>\n<head>\n";
		$this -> DisplayTitle();
		$this -> DisplayKeywords();
		$this -> DisplayStyleFile();
		echo "</head>\n<body>\n";
		echo "<div id=\"wrapper\">";
		$this -> DisplayHeader();
		$this -> DisplayBody($content);
		$this -> DisplayFooter();
		echo "</div> <!-- end of wrapper -->";
		echo "</body>\n</html>\n";
	}
	
	public function DisplayTitle()
	{
		echo "<title>".$this -> title."</title>";
	}
	
	public function DisplayKeywords()
	{
		echo "<meta name=\"keywords\"content=\"".$this->keywords."\"/>";
		echo "<meta charset=\"UTF-8\">
				<meta name=\"google\" content=\"notranslate\">
				<meta http-equiv=\"Content-Language\" content=\"en\">";
	}
	
	public function DisplayStyleFile()
	{
		echo "<link href=\"".$this->styleFile."\" rel=\"stylesheet\" type=\"text/css\"/>";
	}
	
	public function DisplayHeader()
	{

		echo "<div id=\"header\">";
		echo "<div id=\"headercontent\">";
		$this->DisplayLogo();
		$this->DisplaySearchbar();
		echo "</div><!-- end of headercontent div -->";
		echo "</div><!-- end of header div -->";
	}
	
	public function DisplayBody($content)
	{
		echo "<div id=\"bodycontent\">";
		echo $content;
		echo "</div> <!-- end of bodycontent div -->";
	}
	
	public function DisplayFooter()
	{
		echo "<div id=\"footer\">";
		echo "<div id=\"footercontent\">";
		echo "2014 jardin de numa.";
		echo "</div><!-- end of footercontent div -->";
		echo "</div><!-- end of footer div -->";
	}
	
	public function DisplayLogo()
	{
		echo "<div id=\"sitename\">";
		echo "<a href=\"".HOME."\"><img src=\"".LOGO."\" /></a>"; //logo es font size 20, color #808080
		echo "</div>";
	}
	
	public function DisplaySearchbar()
	{
		echo "<div id=\"searchbar\">";
		echo "<form action=\"".SEARCH_RESULTS."\" method=\"get\" class=\"listing\">";
		echo "<input type=\"text\" name=\"q\" id=\"q\" size=\"30px\"/><input type=\"submit\" value=\"buscar\"/>";
		echo "</form>";
		echo "</div><!-- end of searchbar div-->";
	}
	
	public function IsURLCurrentPage($url)
	{
		if(strpos($_SERVER['PHP_SELF'], $url )==false)
		{
			return false;
		}
		else
		{
			return true;
		}
	} 
	
	public function WhatAreItsSubCats($category, $categoryId)
	{
		$subCats;
		if($categoryId == -1)
		{	
			for ($i = 0; $i <= count($this->categories); $i++) {
                $subCats[$i] = $i-1;
            }
            return $subCats;
		}
		else if($category[2] == 1)
		{
			$i = $categoryId;
			$j = 0;
			//store location index in array
			do
			{
				$subCats[$j] = $i;
				$i++;
				$j++;
			} while($this->categories[$i][2] == 2);
			return $subCats;
		}
		else if($category[2] == 2)
		{
			$subCats[0] = $categoryId;
			return $subCats;
		}
	}
	
	public function WhatIsItsParent($cat)
	{
		$i = $cat;
		
		while($this->categories[$i][2] == 2)
		{
			$i--;
		}
		
		return $i;
	}
	
	public function ConnectToDatabase()
	{
		//mysqli_report(MYSQLI_REPORT_ALL);
		
		$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB);
		
		if (mysqli_connect_errno()) {
			echo "Error: No se pudo conectar con la base de datos. Favor de tratar después."; 
			exit;
		}
		

		return $db;
	}
	
	public function CountCategoryListings($db, $cat)
	{
		$subCats = $this->WhatAreItsSubCats($this->categories[$cat], $cat);
		$locations = $this->BuildWhere($subCats);
		
		$stmt = $db->prepare('SELECT * 
				FROM listings
				WHERE location='.$locations);
				
		if($stmt)
			$stmt->execute();
		else
			echo "Hubo un problema con la base de datos.";
			
		$stmt->store_result();
		
		$total = $stmt->num_rows;
		
		$stmt->close();

		return $total;
	}
	
	public function DisplayListingSubTitle($listingDate, $listingLocation, $listingImageAddress)
	{
		$subtitle = "<span class=\"listingsubtitle\">".$listingDate." en ";
		
		if($listingLocation == -1)
		{
			$listingLocationName = "jardin de numa";
			$listingLocation = "";
			
			$subtitle = $subtitle."<span class=\"listinglocation\">&gt;<a href=\"".HOME."?s=".$listingLocation."\">".$listingLocationName."</a></span>";
		}
		else if($this->categories[$listingLocation][2] == 2)
		{
			$listingLocationName = $this->categories[$listingLocation][0];
			
			$parentListingLocation = $this->WhatIsItsParent($listingLocation);
			$parentListingLocationName = $this->categories[$parentListingLocation][0];
			
			$subtitle = $subtitle."<span class=\"listinglocation\">&gt;<a href=\"".HOME."?s=".$parentListingLocation."\">".$parentListingLocationName."</a>&gt;<a href=\"".HOME."?s=".$listingLocation."\">".$listingLocationName."</a></span>";
		}
		else
		{
			$listingLocationName = $this->categories[$listingLocation][0];
			
			$subtitle = $subtitle."<span class=\"listinglocation\">&gt;<a href=\"".HOME."?s=".$listingLocation."\">".$listingLocationName."</a></span>";
		}
		
		if($listingImageAddress)
			$subtitle = $subtitle." <span style=\"color: orange;\">foto</span></span>";
		else
			$subtitle = $subtitle."</span>";
			
		echo $subtitle;
	}

	public function InsertTestListings($db, $n)
	{
		for($i = 1; $i <= $n; $i++)
		{ 
    		$query = "INSERT into listings values (NULL, 0, 'test".$i."', CURDATE(), CURTIME(), 'this is a test', NULL, 'xxxxxxxx')";
    		$result = $db->query($query);
    	}
	}
	
	public function PullIndListing($db, $listingid, &$location, &$title, &$date, &$time, &$description, &$email, &$password, &$imageaddress)
	{									
		$stmt = $db->prepare("SELECT location, title, date, time, description, email, password, imageaddress 
				FROM listings
				WHERE listingid=?");
		
		$stmt->bind_param('i', $listingid);

		if($stmt)
			$stmt->execute();
		else
			echo "Hubo un problema con la base de datos.";
		
		$stmt->bind_result($locationO, $titleO, $dateO, $timeO, $descriptionO, $emailO, $passwordO, $imageaddress0);
			
		while($stmt->fetch()) {
			$location = $locationO;
			$title = $titleO;
			$date = $dateO;
			$time = $timeO;
			$description = $descriptionO;
			$email = $emailO;
			$password = $passwordO;
			$imageaddress = $imageaddress0;
		}
		
		$stmt->close();	
	}
	
	public function DisplaySuccess($content)
	{
		 echo "<div id=\"bodycontent\">\n";
		 echo "<div id =\"processsuccess\">\n";
		 echo $content;
		 echo "</div> <!-- end of processsuccess div -->\n";
		 echo "</div> <!-- end of bodycontent div -->\n";
	}
	
	public function DisplayError($content)
	{
		 echo "<div id=\"bodycontent\">\n";
		 echo "<div id =\"processerror\">\n";
		 echo $content;
		 echo "</div> <!-- end of processerror div -->\n";
		 echo "</div> <!-- end of bodycontent div -->\n";
	}
	
	public function BuildLocationList($defaultLocation)
	{
		$selectContent="<option value=\"-1\"></option>";
		$tempString;
		$k = 0;

		for ($i = 0; $i<count($this->categories); $i++) {
			$k = $i;
			
			if(!($k == $defaultLocation))
			{
				if ($this->categories[$i][2] == 1)
				{
					$tempString = "<option value=\"".$k."\">".$this->categories[$i][0]."</option>";
				}
				if ($this->categories[$i][2] == 2)
				{
					$tempString = "<option value=\"".$k."\">&nbsp;&nbsp;&nbsp;".$this->categories[$i][0]."</option>";
				}	
			}
			else 
			{
				if ($this->categories[$i][2] == 1)
				{
					$tempString = "<option selected=\"selected\" value=\"".$k."\">".$this->categories[$i][0]."</option>";
				}
				if ($this->categories[$i][2] == 2)
				{
					$tempString = "<option selected=\"selected\" value=\"".$k."\">&nbsp;&nbsp;&nbsp;".$this->categories[$i][0]."</option>";
				}
			}
			
			$selectContent = $selectContent.$tempString;
		}
		 return $selectContent;
	}
}
?>
