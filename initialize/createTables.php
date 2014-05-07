<?php
/*

*	File:		createTables.php
*	By:			Linn Thomas
*	Date:		2014-05-02
*
*	Initialize tables for HoneyDo List
*
*
*=====================================
*/

{  //  Secure Connection

	include('../../../htconfig/dbInitialize_HoneyDo.php');
	
	// I have changed my database connection to use mysqli rather than mysql_connect
	

$dbSuccess = false;
 $dbConnected = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
 $dbName = $db['database'];
 $thisScriptName = "createTables.php";
 
 // Check connection
 if (mysqli_connect_errno()) {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

}
  // This is the connection trap
  if($dbConnected){
  	
  	// This script drops and recreates the tables for the Honeydo List
  	//  User confirmation
  	
  	if (isset($_POST["continue"])){ $continue = $_POST['continue']; };
  	
	 echo "This script drops all the tables.  Are you sure you want to do this?  Type 'yes' to continue: ";
	 echo '<form action='.$thisScriptName.' method="post">
	 				<input type="text" name="continue" />
			
			    </form>';
			    
	if(isset($continue)) {
		if(trim($continue) != 'yes' ) { 
					echo "<font color='red'>ABORTING!\n</font>";
					exit;
			}
		} else { 
				exit;
				}
		
	// Because I have foreign keys I have to turn them off to run this script
	
	mysqli_query($dbConnected,'SET foreign_key_checks = 0');
	
	{  // Let's drop table tPriority

	$tablePriorityName = "tPriority";	

			$drop_Priority_SQL = "DROP TABLE ".$tablePriorityName;
			
			if (mysqli_query($dbConnected, $drop_Priority_SQL))  {	
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
			
			if (mysqli_query($dbConnected, $createTablePriority_SQL))  {	
				echo "'CREATE ".$tablePriorityName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tablePriorityName."' - Failed.".'<br />';
			}
	}
	{  // Drop Status Table
	$tableStatusName = "tStatus";
	
	$drop_Status_SQL = "DROP TABLE ".$tableStatusName;
			
			if (mysqli_query($dbConnected, $drop_Status_SQL))  {	
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
			
			if (mysqli_query($dbConnected, $createTableStatus_SQL))  {	
				echo "'CREATE ".$tableStatusName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableStatusName."' - Failed.".'<br />';
			}
		}
		
	{  //  Drop tCategory
	$tableCategoryName = "tCategory";
	$drop_Category_SQL = "DROP TABLE ".$tableCategoryName;
			
			if (mysqli_query($dbConnected, $drop_Category_SQL))  {	
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
					
					if (mysqli_query($dbConnected, $createTableCategory_SQL))  {	
				echo "'CREATE ".$tableCategoryName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableCategoryName."' - Failed.".'<br />';
			}
		}
	{  // Drop Table - tListEntries
	
		$tableListEntriesName = "tListEntries";
		
		$drop_ListEntries_SQL = "DROP TABLE ".$tableListEntriesName;
				
				if (mysqli_query($dbConnected, $drop_ListEntries_SQL))  {	
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
			
			if (mysqli_query($dbConnected, $createTableListEntries_SQL))  {	
				echo "'CREATE ".$tableListEntriesName."' -  Successful.".'<br />';
			} else {
				echo "'CREATE ".$tableListEntriesName."' - Failed.".'<br />';
			}
		}
		{  //Drop table tDescription
		$tableDescriptionName = "tDescription";		
		$drop_Description_SQL = "DROP TABLE ".$tableDescriptionName;
			
			if (mysqli_query($dbConnected, $drop_Description_SQL))  {	
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
				'Prerequisites',
				'Req_Materials',
				'NextAction'
		);
		
		$numFieldsDescription = sizeof($tableDescriptionField);
		
		echo 'Number of Fields in Description : '.$numFieldsDescription.'<br />';
		
		$createTableDescription_SQL = "
					CREATE TABLE ".$dbName.".".$tableDescriptionName." (
					ID INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					List_Id INT (11) NOT NULL,
					Description TEXT,
					NextAction TEXT,
					Prerequisites TEXT,
					Req_Materials TEXT
					)";
	}	
	{	//		CREATE table - Description		
			
			if (mysqli_query($dbConnected, $createTableDescription_SQL))  {	
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
			
		if (mysqli_query($dbConnected, $priority_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
		
		echo "<strong><u>SQL for Status Table:<br /></u></strong>";
		echo $status_SQLinsert."<br /><br />";
			
		if (mysqli_query($dbConnected, $status_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
		
		echo "<strong><u>SQL for Category Table:<br /></u></strong>";
		echo $category_SQLinsert."<br /><br />";
			
		if (mysqli_query($dbConnected, $category_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}
	}
	
	// Now with everything else done except the limited user I will turn foreign key checking back on
	
	mysqli_query($dbConnected, 'SET foreign_key_checks = 1');
	
	{  // Now I'm going to create a limited user for this database
		// From a seperate initialization file
//		include('../../../htconfig/dbConfig_HoneyDo.php');
		
		
	$createUser_SQL = "
			GRANT insert, update, delete, select ON ".$db['database'].".* TO honeydo@localhost IDENTIFIED BY 'MommasHappy'";
	if (mysqli_query($dbConnected, $createUser_SQL))	 {
		echo "CREATE USER was SUCCESSFUL. <br /><br />";
		} else {
		echo "CREATE USER FAILED. <br /><br />";
		}
	}	

}  //End of Connection Trap

?>