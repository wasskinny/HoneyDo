<?php
/*

*	File:		createTables_honeydo.php
*	By:		Linn Thomas
*	Date:		04/19/2014

=====================================
*/

{  //  First Our Secure Connection

	include('../../../htconfig/dbConfig_HoneyDo.php');
		$dbSuccess = false;
		$dbConnected = mysql_connect($db['hostname'], $db['username'], $db['password']);
		$dbName = $db['database'];

	if($dbConnected) {
	$dbSelected = mysql_select_db($db['database'],$dbConnected);
	if($dbSelected) {
		$dbSuccess = true;
	} else {
		echo "Database Connection FAILED!";
		}
	}	else {
		echo "MySQL Connection FAILED!";	
	}
}

// And this is the connection trap

if($dbSuccess) {
	

	{	//		Table Definition
	
		$tableName = "tTasks";	

		$tableField = array(
					'Create_Date',
					'Discription',
					'Prerequisites',
					'Materials',			
					'Acquired',			
					'Completed',	
		);
		$numFields = sizeof($tableField);
		
		echo '$numFields : '.$numFields.'<br />';
		echo '$dbName : '.$dbName.'<br />';

		$createTable_SQL = "
					CREATE TABLE ".$dbName.".".$tableName." (
					ID INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					Create_Date DATE,
					Description VARCHAR( 250 ) NOT NULL,
					Prerequisites VARCHAR( 250 )  NULL,
					Materials VARCHAR( 250 )  NULL,
					Acquired TINYINT(1)  NULL,
					Completed TINYINT(1)  NULL
		)";
		
				{	//		DROP table		
	
		
			$drop_SQL = "DROP TABLE ".$tableName;
			
			if (mysql_query($drop_SQL))  {	
				echo "'DROP ".$tableName."' -  Successful.";
			} else {
				echo "'DROP ".$tableName."' - Failed.";
			}
		}
		
		echo "<br /><hr /><br />";
	
		{	//		CREATE table		
			
			if (mysql_query($createTable_SQL))  {	
				echo "'CREATE ".$tableName."' -  Successful.";
			} else {
				echo "'CREATE ".$tableName."' - Failed.";
			}
		}		
		echo "<br /><hr /><br />";

		// Lets error check table creation
				if (mysql_query($createTable_SQL))
		  {
		  echo "Table $tablename created successfully";
		  }
		else
		  {
		  echo "Error creating table:" . mysql_error($createTable_SQL);
			}
	
	
	
}

}
?>