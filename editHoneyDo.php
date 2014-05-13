<?php
/*

*	File:		editHoneyDo.php
*	By:			Linn Thomas
*	Date:		2014-05-10
*
*	Edits HoneyDos from List
*
*
*=====================================
*/

{  //  Secure Connection

	include('../../../htconfig/dbConfig_HoneyDo.php');
	
	// I have changed my database connection to use mysqli rather than mysql_connect
	

$dbSuccess = false;
 $dbConnected = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
 
 // Check connection
 if (mysqli_connect_errno()) {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

}
  // This is the connection trap
  if($dbConnected){
	$thisScriptName = "editHoneyDo.php";
	
  // Check for my incoming variable which is the HoneyDo ID
 if (isset($_GET["listID"])){ $listID = $_GET['listID']; };

 echo "This is the listID variable: $listID <br />";

{  // Create a record in the tDescription Table with the ID from the tListEntries Table
   //  First I need to check and see if it already exists
   
   $listIDexists = mysqli_query($dbConnected,"SELECT List_Id FROM tDescription WHERE List_Id = $listID");
   $num_rows = mysqli_num_rows($listIDexists);
   
   echo "This is the Number of Rows variable: $num_rows <br />";
   
   // If it doesn't, add it to the tDescription Table

		if($num_rows == 0) {
			
			$insertDescription_SQL = "INSERT INTO tDescription ";
			$insertDescription_SQL .= "(List_Id) ";
			$insertDescription_SQL .= "VALUES (".$listID.")"; 
			
			// echo "$insertDescription_SQL <br />";
			
			mysqli_query($dbConnected, $insertDescription_SQL);
			}
	
 
}


{  // I need to call the rest of the fields from the tListEntries
   // I'm also going to add description, prerequites and Required Materials from tDescription Table
   
   $editHoneyDos_SQL = "SELECT * ";
   $editHoneyDos_SQL .= "FROM tListEntries AS l ";
	$editHoneyDos_SQL .= "JOIN tDescription ON l.ID = tDescription.List_Id ";
   $editHoneyDos_SQL .= "WHERE l.ID=$listID ";
  
   
   echo "This is the editHoneyDos SQL Statement ".$editHoneyDos_SQL." <br />";
   
   mysqli_query($dbConnected, $editHoneyDos_SQL);
}


 echo '<br /><a href="index.php">Go Back to Home </a>';
 
}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   
    }


?>