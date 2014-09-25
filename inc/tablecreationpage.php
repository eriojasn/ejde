<?php
    require("/home/eriojasn/inc/page.php");

    class TableCreationPage extends Page 
    {
    	public function CreateAndConfigureTable()
    	{
    		$status = "";
    		$success = false;
    		$tablename = "listings";
    		
    		$db = $this->ConnectToDatabase();
    		
    		if($db)
    		{
    			$status = $status."connected to database\n";
    		}
    		else
    		{
    			$status = $status."unable to connect to database\n";
    		}
    		
    		//create table
    		$query = "CREATE TABLE ".$tablename."
    				(
    				listingid int(10) unsigned not null auto_increment primary key,
    				location int(11) not null,
    				title char(150) not null,
    				date date not null,
    				time time not null,
    				description text,
    				email tinytext,
    				password char(8) not null
    				)";
    
    		$success = $db->query($query);
    		
    		if($success)
    		{
    			$status = $status."table created\n";
    		}
    		else
    		{
    			$status = $status."unable to create table\n";
    		}
    		
    		//change storage engine
    		$query = "ALTER TABLE ".$tablename."
    				ENGINE = MyISAM
    				";
    				
    		$success = $db->query($query);
    		    		
    		if($success)
    		{
    			$status = $status."storage engine changed\n";
    		}
    		else
    		{
    			$status = $status."unable to change storage engine\n";
    		}
    		
    		//add fulltext index
    		$query = "ALTER TABLE ".$tablename."
    				ADD FULLTEXT (title, description)
    				";
    				
    		$success = $db->query($query);
    		    		
    		if($success)
    		{
    			$status = $status."fulltext index added\n";
    		}
    		else
    		{
    			$status = $status."unable to add fulltext index\n";
    		}
    		
    		return $status;
    	}
    }
?>