<?php
	
/* In my desire to learn php... I guess I gotta do stuff
This is a simple checklist for my honey dos...

So, the first thing is to initialize a database using mysql

*/

{  //  First Our Secure Connection - exclude database connection because we are creating the database

	include('../../../htconfig/dbConfig_HoneyDo.php');

// $dbSuccess = false;
$dbConnected = mysql_connect($db['hostname'], $db['username'], $db['password']);
$dbName = $db['database'];

echo 'The database name is ' . $dbName . '<br />';

	if($dbConnected) {
//	$dbSelected = mysql_select_db($db['database'],$dbConnected);
//	if($dbSelected) {
//		$dbSuccess = true;
//	} else {
//		echo "Database Connection FAILED!";
//		}
	}	else {
		die('MySQL Connection FAILED! error: ' . mysql_error());	
	}
	

}	

// if($dbSucess) 

{

$sql = 'Create DATABASE' ." $dbName";

if(mysql_query($sql,$dbConnected)) {
	echo "Database Creation SUCCESSFUL!";
} else {
	echo 'Error Creating database - ' . "$dbName" . ': ' . mysql_error() . "\n";
	}


}

?>