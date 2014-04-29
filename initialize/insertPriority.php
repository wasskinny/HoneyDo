<?php

{  //  First Our Secure Connection

	include('../../../htconfig/dbConfig_HoneyDo.php');

$dbSuccess = false;
$dbConnected = mysql_connect($db['hostname'], $db['username'], $db['password']);

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

if($dbSuccess) {


		$priorityData[0] = array(NULL, 'High', 1);
		$priorityData[1] = array(NULL, 'Medium', 5);
		$priorityData[2] = array(NULL, 'Low', 10);
		$priorityData[3] = array(NULL, 'None', 99);
		
		$numPriorityRows = sizeof($priorityData);
		
		$priority_SQLinsert = "INSERT INTO tPriority (
									".$priorityField['Name'].",
									".$priorityField['Priority']."							
									) ";
		$priority_SQLinsert .=  "VALUES ";
		
		$priorityindx = 0;
				
		while($priorityindx < $numPriorityRows) {			
			$priority_SQLinsert .=  "(
										'".$priorityData[$priorityindx][0]."',
										'".$priorityData[$priorityindx][1]."',
										'".$priorityData[$priorityindx][2]."',
										'".$priorityData[$priorityindx][3]."'
										) ";
			if ($priorityindx < ($numRows - 1)) {
				$priority_SQLinsert .=  ",";
			}
			
			$priorityindx++;
		}
{
		echo "<strong><u>SQL for Priority Table:<br /></u></strong>";
		echo $priority_SQLinsert."<br /><br />";
			
		if (mysql_query($priority_SQLinsert))  {				
			echo "was SUCCESSFUL.<br /><br />";
		} else {
			echo "FAILED.<br /><br />";		
		}								
}		
}  //  End of Connection Trap

?>