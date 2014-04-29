<?php
/*

*	File:		createTables_honeydo.php
*	By:		Linn Thomas
*	Date:		04/19/2014

	This is to create the tables for the revised honeydo task list
	This script will destory existing data in the tables, so be warned
	
	Because of the Foreign Key Strings this script only works once.  The foreign key
	protects the tables so to drop you must turn off foreign key protection or
	manually drop the tables

=====================================
*/

{  //  First Our Secure Connection

	include('../../../htconfig/dbInitialize_HoneyDo.php');
		$dbSuccess = false;
		$dbConnected = mysql_connect($db['hostname'], $db['username'], $db['password']);
		$dbName = $db['database'];

	if($dbConnected) {
	$dbSelected = mysql_select_db($db['database'],$dbConnected);
	if($dbSelected) {
		$dbSuccess = true;
		echo "Database connected".'<br />';
	} else {
		echo "Database Connection FAILED!";
		}
	}	else {
		echo "MySQL Connection FAILED!";	
	}
}

// And this is the connection trap

if($dbSuccess) {
	
	// Because I have foreign keys I have to turn them off to run this script
	
	mysql_query('SET foreign_key_checks = 0');
	
	{  // Let's drop table tPriority

	$tablePriorityName = "tPriority";	

			$drop_Priority_SQL = "DROP TABLE ".$tablePriorityName;
			
			if (mysql_query($drop_Priority_SQL))  {	
				echo "'DROP ".$tablePriorityName."' -  Successful.".'<br />';
			} else {
				echo "'DROP ".$tablePriorityName."' - Failed.".'< br />';
			}
	}
	
	{	//  Table Definition - Priority
	
		
		$tablePriorityField = array(
					'ID',
					'Name',
					'Priority'
		);
		$numFieldsPriority = sizeof($tablePriorityField);
		
		echo 'Number of Fields in Priority DB : '.$numFieldsPriority.'<br />';
		echo 'The Database Name is : '.$dbName.'<br />';

		$createTablePriority_SQL = "
					CREATE TABLE ".$dbName.".".$tablePriorityName." (
					ID INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					Name VARCHAR(20),
					Priority TINYINT
		)";

	}
	{	//		CREATE table - Priority
			
			if (mysql_query($createTablePriority_SQL))  {	
				echo "'CREATE ".$tablePriorityName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tablePriorityName."' - Failed.".'<br />';
			}
	}
	{  // Drop Status Table
	$tableStatusName = "tStatus";
	
	$drop_Status_SQL = "DROP TABLE ".$tableStatusName;
			
			if (mysql_query($drop_Status_SQL))  {	
				echo "'DROP ".$tableStatusName."' -  Successful.".'<br />';
			} else {
				echo "'DROP ".$tableStatusName."' - Failed.".'<br />';
			}
	}	
	
	{  //  Table Definition - Status
	
		$tableStatusField = array(
				'ID',
				'Status'
		);
		$numFieldsStatus = sizeof($tableStatusField);

		echo 'Number of Fields in Status : '.$numFieldsStatus.'<br />';
		
		$createTableStatus_SQL = "
					CREATE TABLE ".$dbName.".".$tableStatusName." (
					ID INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					Status VARCHAR(20)
		)";
	}
		{	//		CREATE table - Status
			
			if (mysql_query($createTableStatus_SQL))  {	
				echo "'CREATE ".$tableStatusName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableStatusName."' - Failed.".'<br />';
			}
		}
		
	{  //  Drop tCategory
	$tableCategoryName = "tCategory";
	$drop_Category_SQL = "DROP TABLE ".$tableCategoryName;
			
			if (mysql_query($drop_Category_SQL))  {	
				echo "'DROP ".$tableCategoryName."' -  Successful.".'<br />';
			} else {
				echo "'DROP ".$tableCategoryName."' - Failed.".'<br />';
			}
	}
	{  //  Table Definition - Category
		
		$tableCategoryField = array(
				'ID',
				'Category'
		);
		$numFieldsCategory = sizeof($tableCategoryField);
		
		echo 'Number of Fields in Category : '.$numFieldsCategory.'<br />';
		
		$createTableCategory_SQL = "
					CREATE TABLE ".$dbName.".".$tableCategoryName." (
					ID INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					Category VARCHAR(20)
		)";
					
					if (mysql_query($createTableCategory_SQL))  {	
				echo "'CREATE ".$tableCategoryName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableCategoryName."' - Failed.".'<br />';
			}
		}
	{  // Drop Table - tListEntries
	
		$tableListEntriesName = "tListEntries";
		
		$drop_ListEntries_SQL = "DROP TABLE ".$tableListEntriesName;
				
				if (mysql_query($drop_ListEntries_SQL))  {	
					echo "'DROP ".$tableListEntriesName."' -  Successful.".'<br />';
				} else {
					echo "'DROP ".$tableListEntriesName."' - Failed.".'<br />';
				}
	}
	
	{   //  Table Definition - List Entries
	
		$tableListEntriesField = array(
				'ID',
				'Subject',
				'Start_Date',
				'Due_Date',
				'Create_Date',
				'Complete_Date',
				'priority_Id',
				'status_Id',
				'category_Id',
				'Last_Modified'
		);
		
		$numFieldsListEntries = sizeof($tableListEntriesField);
		
		echo 'Number of Fields in ListEntries : '.$numFieldsListEntries.'<br />';
		
		$createTableListEntries_SQL = "
					CREATE TABLE ".$dbName.".".$tableListEntriesName." (
					ID INT (11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					Subject VARCHAR(75) NOT NULL,
					Start_Date DATETIME,
					Due_Date DATETIME,
					Create_Date DATETIME,
					priority_Id INT (11) UNSIGNED NOT NULL,
					status_Id INT (11) UNSIGNED NOT NULL,
					category_Id INTEGER UNSIGNED NOT NULL,
					Last_Modified TIMESTAMP,
					INDEX (category_id),
					INDEX (status_id),
					INDEX (priority_id),
					FOREIGN KEY (category_id) REFERENCES ".$tableCategoryName."(ID),
					FOREIGN KEY (status_id) REFERENCES ".$tableStatusName."(ID),
					FOREIGN KEY (priority_id) REFERENCES ".$tablePriorityName."(ID)
					)";
		}
		
		{	//		CREATE table - List Entries		
			
			if (mysql_query($createTableListEntries_SQL))  {	
				echo "'CREATE ".$tableListEntriesName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableListEntriesName."' - Failed.".'<br />';
			}
		}
		{  //Drop table tDescription
		$tableDescriptionName = "tDescription";		
		$drop_Description_SQL = "DROP TABLE ".$tableDescriptionName;
			
			if (mysql_query($drop_Description_SQL))  {	
				echo "'DROP ".$tableDescriptionName."' -  Successful.".'<br />';
			} else {
				echo "'DROP ".$tableDescriptionName."' - Failed.".'<br />';
			}
		
		}
	{  //   Table Definition - Description
	
		
		$tableDescriptionField = array(
				'ID',
				'List_Id',
				'Description',
				'NextAction'
		);
		
		$numFieldsDescription = sizeof($tableDescriptionField);
		
		echo 'Number of Fields in Description : '.$numFieldsDescription.'<br />';
		
		$createTableDescription_SQL = "
					CREATE TABLE ".$dbName.".".$tableDescriptionName." (
					ID INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					List_Id INT (11) NOT NULL,
					Description TEXT,
					NextAction TEXT
					)";
	}	
	{	//		CREATE table - Description		
			
			if (mysql_query($createTableDescription_SQL))  {	
				echo "'CREATE ".$tableDescriptionName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableDescriptionName."' - Failed.".'<br />';
			}
		}		
		echo "<br /><hr /><br />";
	
	{ // Insert Initial Data into the tables
	
	{  // Setup field names
			//Starting with the tPriority
			
			$priorityField = array(
					'ID' => 'ID',
					'Name' => 'Name',
					'Priority' => 'Priority',
				);	
				
			$statusField = array(
					'ID' => 'ID',
					'Status' => 'Status',		
			);
			
			$categoryField = array(
					'ID' => 'ID',
					'Category' => 'Category',			
			);
	}
		
			
		{	// setup ARRAY of data ROWS

		$priorityData[0] = array( 'High', 1);
		$priorityData[1] = array( 'Medium', 5);
		$priorityData[2] = array( 'Low', 10);
		$priorityData[3] = array( 'None', 99);
		
		$numPriorityRows = sizeof($priorityData);
		
		$statusData[0] = array(1, 'Not Started',);
		$statusData[1] = array(2, 'Deferred',);
		$statusData[2] = array(3, 'Waiting on Someone',);
		$statusData[3] = array(50, 'In Progress',);
		$statusData[4] = array(98, 'Cancelled',);
		$statusData[5] = array(99, 'Completed',);
		
		$numStatusRows = sizeof($statusData);
		
		$categoryData[0] = array(NULL, 'None');
		$categoryData[1] = array(NULL, 'Personal');
		$categoryData[2] = array(NULL, 'Work');
		$categoryData[3] = array(NULL, 'Other');
		
		$numCategoryRows = sizeof($categoryData);
		
		}	

		{	// SQL statement with ARRAYS 
		
		//   Fieldnames part of INSERT statement 
		
		$priority_SQLinsert = "INSERT INTO tPriority (
									".$priorityField['Name'].",
									".$priorityField['Priority']."					
									) ";
		$priority_SQLinsert .=  "VALUES ";
		
		$priorityindx = 0;
				
		while($priorityindx < $numPriorityRows) {			
			$priority_SQLinsert .=  "(
										'".$priorityData[$priorityindx][0]."',
										'".$priorityData[$priorityindx][1]."'
										) ";
			
			if ($priorityindx < ($numPriorityRows - 1)) {
				$priority_SQLinsert .=  ",";
			}
			
			$priorityindx++;
		}								
		
		$status_SQLinsert = "INSERT INTO tStatus (
									".$statusField['ID'].",
									".$statusField['Status']."							
									) ";
		$status_SQLinsert .=  "VALUES ";
		
		$statusindx = 0;		
		
		while($statusindx < $numStatusRows) {			
			$status_SQLinsert .=  "(
										'".$statusData[$statusindx][0]."',
										'".$statusData[$statusindx][1]."'
										) ";
			if ($statusindx < ($numStatusRows - 1)) {
				$status_SQLinsert .=  ",";
			}
	
			$statusindx++;
		}		
		
		$category_SQLinsert = "INSERT INTO tCategory (
									".$categoryField['ID'].",
									".$categoryField['Category']."
									) ";
		$category_SQLinsert .=  "VALUES ";
									
		$categoryindx = 0;		
		
		while($categoryindx < $numCategoryRows) {			
			$category_SQLinsert .=  "(
										'".$categoryData[$categoryindx][0]."',
										'".$categoryData[$categoryindx][1]."'
										) ";
			if ($categoryindx < ($numCategoryRows - 1)) {
				$category_SQLinsert .=  ",";
			}
			
			$categoryindx++;
		}
	
						

	
	}
		
	}		
		
	{	//	Echo and Execute the SQL and test for success   
		
		echo "<strong><u>SQL for Priority Table:<br /></u></strong>";
		echo $priority_SQLinsert."<br /><br />";
			
		if (mysql_query($priority_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
		
		echo "<strong><u>SQL for Status Table:<br /></u></strong>";
		echo $status_SQLinsert."<br /><br />";
			
		if (mysql_query($status_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
		
		echo "<strong><u>SQL for Category Table:<br /></u></strong>";
		echo $category_SQLinsert."<br /><br />";
			
		if (mysql_query($category_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
	}
	
	// Now with everything else done except the limited user I will turn foreign key checking back on
	
	mysql_query('SET foreign_key_checks = 1');
	
	{  // Now I'm going to create a limited user for this database
		// From a seperate initialization file
//		include('../../../htconfig/dbConfig_HoneyDo.php');
		
		
	$createUser_SQL = "
			GRANT insert, update, delete, select ON ".$db['database'].".* TO honeydo@localhost IDENTIFIED BY 'MommasHappy'";
	if (mysql_query($createUser_SQL))	 {
		echo "CREATE USER was SUCCESSFUL. <br /><br />";
		} else {
		echo "CREATE USER FAILED. <br /><br />";
		}
	}	

}  //End of Connection Trap

?>