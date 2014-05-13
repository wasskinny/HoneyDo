<?php
/*

*	File:		deleteHoneyDo.php
*	By:			Linn Thomas
*	Date:		2014-05-10
*
*	Deletes HoneyDos from List
*
*
*=====================================
*/

{  //  Secure Connection

	include('../../../htconfig/dbConfig_HoneyDo.php');
	
	// I have changed my database connection to use PDO rather than mysql_connect
	

$dbSuccess = false;
 $dbConnected = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
 
 // Check connection
 if (mysqli_connect_errno()) {
 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

}
  // This is the connection trap
  if($dbConnected){

  // Check for my incoming variable which is the HoneyDo ID
 if (isset($_GET["listID"])){ $listID = $_GET['listID']; };

//  echo $listID;

{  // SQL to delete the record from the Honeydo tListEntries from the carried over ID

	$deleteListEntry_SQL = "DELETE FROM ";
	$deleteListEntry_SQL .= "tListEntries ";
	$deleteListEntry_SQL .= "WHERE ";
	$deleteListEntry_SQL .= "ID = $listID";

}

  echo $deleteListEntry_SQL ;
  
{ // Now lets run the SQL Statement

	if (mysqli_query($dbConnected, $deleteListEntry_SQL)) {
		header("Location: index.php");
	} else {
	 echo "Failed to Delete $listID";
	}


}

 echo '<br /><a href="index.php">Go Back to Home </a>';
 
}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   }


?>