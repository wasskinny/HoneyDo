<?php
/*

*	File:		addHoneyDo.php
*	By:			Linn Thomas
*	Date:		2014-05-02
*
*	This script will take the information from the add form
*  in content.php and insert it into the database
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
 
 $thisScriptName = "addHoneydo.php";

}
  // This is the connection trap
  if($dbConnected){
  	
	{ 	// The fields carried in from content.php

				$fld_Priority = $_POST["Priority"];	
				$fld_Status = $_POST["Status"];	
				$fld_Subject = $_POST["Subject"];	
				$fld_Due_Date = $_POST["Due_Date"];	
	}				
				
				
				
				
				
				echo "$fld_Priority <br />";
				echo "$fld_Status <br />" ;
				echo "$fld_Subject <br />";
				echo "$fld_Due_Date <br />" ;
				
			
				$tListEntries_SQLinsert = "INSERT INTO tListEntries (";			
				$tListEntries_SQLinsert .=  "priority_Id, ";
				$tListEntries_SQLinsert .=  "status_Id, ";
				$tListEntries_SQLinsert .=  "Subject, ";
				$tListEntries_SQLinsert .=  "Due_Date ";
				$tListEntries_SQLinsert .=  ") ";
				
				$tListEntries_SQLinsert .=  "VALUES (";
				$tListEntries_SQLinsert .=  "'".$fld_Priority."', ";
				$tListEntries_SQLinsert .=  "'".$fld_Status."', ";
				$tListEntries_SQLinsert .=  "'".$fld_Subject."', ";
				$tListEntries_SQLinsert .=  "'".$fld_Due_Date."', ";	
				$tListEntries_SQLinsert .=  ") ";
				
	if (mysqli_query($dbConnected, $tListEntries_SQLinsert))  {	
		
			// header("Location: companyPeopleEdit.php?companyID=".$companyID);
			
		} else {
			
			echo '<br /><span style="color:red; ">FAILED to add Honey Do.</span><br /><br />';
			echo "<br /><hr /><br />";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<a href="index.php">Quit - to homepage</a>';
			
		}				



}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   }


?>