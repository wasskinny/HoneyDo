<?php
/*

*	File:		formHoneyDo.php
*	By:		Linn Thomas
*	Date:		2014-04-20

=====================================

This is the form for the Honey Do List.  I will be a single form with a list of the HoneyDo's
Add, Edit and complete.

*/

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

// This script name variable for use in the form
$thisScriptName = "formHoneyDo.php";

if($dbSuccess) {

		{	//  Get the details of all existing honeydos from the tTasks table
				//		and store in array:  tasksArray  with key >$indx
				 
					$indx = 0;
				
					$tTasks_SQLselect = "SELECT * ";
					$tTasks_SQLselect .= "FROM ";
					$tTasks_SQLselect .= "tTasks ";
//					$tTasks_SQLselect .= "Order By Description ASC, Completed ";
					
					$tTasks_SQLselect_Query = mysql_query($tTasks_SQLselect);	
					
					while ($row = mysql_fetch_array($tTasks_SQLselect_Query, MYSQL_ASSOC)) {
						
						//		we need this to pass to personEdit.php
						$tasksArray[$indx]['ID'] = $row['ID'];
						//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
						
						$tasksArray[$indx]['Create_Date'] = $row['Create_Date'];
						$tasksArray[$indx]['Description'] = $row['Description'];
						$tasksArray[$indx]['Prerequisites'] = $row['Prerequisites'];
						$tasksArray[$indx]['Materials'] = $row['Materials'];
						$tasksArray[$indx]['Acquired'] = $row['Acquired'];
						$tasksArray[$indx]['Completed'] = $row['Completed'];
							
						$indx++;			 
					}
		
					$numTasks = sizeof($tasksArray);
							
					mysql_free_result($tTasks_SQLselect_Query);			
			}

			{  // Now we need a form that is editable and sortable from the header row
			
	// Lets do some alternating row colors... we will later do this with css, but I don't know how yet			
	$tdOdd = 'style = "background-color: #FF8F8F;"';
	$tdEven = 'style = "background-color: #76E9FF;"';		

	echo '<div style="margin-left: 100; ">';
				
	{	//		Table of tTasks records
							echo '<table border="1" padding="5">';
								echo '<tr>
												<td>Creation Date</td>
												<td>Description</td>
												<td>Prerequisites</td>
												<td>Materials</td>
												<td>Acquired</td>
												<td>Completed</td>
												<td width="90">&nbsp;</td>
										</tr>	';	
																		
								for ($indx = 0; $indx < $numTasks; $indx++) {
									$thisID = $tasksArray[$indx]['ID'];
									$tasksEditLink = '<a href="EditForm.php?personID='.$thisID.'">Edit</a>';
									
		        					if (($indx % 2) == 1) {$rowClass = $tdOdd; } else { $rowClass = $tdEven; }  
		 
									echo '<tr '.$rowClass.' height="20">
									
												<td>'.$tasksArray[$indx]['Create_Date'].'</td>
												
												<td>'.$tasksArray[$indx]['Description'].'</td>
		
												<td>'.$tasksArray[$indx]['Prerequisites'].'</td>
		
												<td>'.$tasksArray[$indx]['Materials'].'</td>
												
												<td>'.$tasksArray[$indx]['Acquired'].'</td>
												
												<td>'.$tasksArray[$indx]['Completed'].'</td>
												
												<td>'.$tasksEditLink.'</td>
												
											</tr>	';			     
								}
							echo '</table>';

	}
	{  //And a table to add records
	
	}		

}

}
?>