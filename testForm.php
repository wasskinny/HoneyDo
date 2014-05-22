<?php
/*

*	File:		testForm.php
*	By:			Linn Thomas
*	Date:		2014 05 18
*
*	Test Output from Form
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

	$listID = $_POST['listID']	; 	
	 	$categoryID = $_POST['categoryID'];
   		$categoryName = $_POST['categoryName'];
   		$DueDate = $_POST['DueDate'];
   		$priority_Id = $_POST['priority_Id'];
   		$statusID = $_POST['statusID'];
   		$description = $_POST['description'];
   		$nextAction = $_POST['nextAction'];
   		$prerequisites = $_POST['prerequisites'];
   		$reqMaterials = $_POST['req_Materials'];
   		
		echo 'saveClicked = '.$_POST['saveClicked'].' <br />';   		
   		echo 'ListID = '.$listID.' <br />';
   		echo '$categoryID = '.$categoryID.' <br />';
   		echo '$categoryName = '.$categoryName.' <br />';
   		echo '$DueDate = '.$DueDate.' <br />';
   		echo '$priority_Id = '.$priority_Id.' <br />';
   		echo '$statusID = '.$statusID.' <br />';
   		echo '$description = '.$description.' <br />';
   		echo '$nextAction = '.$nextAction.' <br />';
   		echo '$prerequisites = '.$prerequisites.' <br />';
   		echo '$reqMaterials = '.$reqMaterials.' <br />';





}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   }


?>