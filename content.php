<div id="content" style="background-color:#EEEEEE;height:400px">

<?php
/*

*	File:		content.php
*	By:			Linn Thomas
*	Date:		2014-04-26
*
*	This script is the content portion of my HoneyDo list
*  It will create the table for adding and editting honeydos
*
*
*=====================================
*/

{  //  First Our Secure Connection

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

	// This is the name of the script
	$thisScriptName = 'content.php';
	
	// This is to check the variable for adding HoneyDos and prevent an undefined error
	
	if (isset($_POST["saveClicked"])){ $saveClicked = $_POST['saveClicked']; };
	
	{	//	SAVE button was clicked 
		if (isset($saveClicked)) {
			unset($saveClicked);
			
			$tListEntriesID = $_POST["ListEntriesID"];
			
			$priorityID = $_POST["Priority"];	
			$statusID = $_POST["Status"];	
			$subject = $_POST["Subject"];	
			$action = $_POST["Action"];	
	
			$tListEntries_SQLupdate = "UPDATE tListEntries SET ";	
			$tListEntries_SQLupdate .=  "Priority = '".$Priority."', ";
			$tListEntries_SQLupdate .=  "Status = '".$Status."', ";
			$tListEntries_SQLupdate .=  "Subject = '".$Subject."', ";
			$tListEntries_SQLupdate .=  "WHERE ID = '".$tListEntriesID."' "; 	
	
			if (mysqli_query($tListEntries_SQLupdate))  {	
				echo header("Location: HoneyDo List");
			} else {
				echo '<span style="color:red; ">FAILED to update the HoneyDo.</span><br /><br />';
				
			}				
		}	
	//	END:  SAVE button was clicked 	ie. if (isset($saveClicked))
	}		
	{  // Pull the existing HoneyDo's from the database
  
  $getExisting_SQL = "Select l.ID, p.name, l.subject, s.status, ";
  $getExisting_SQL .= 'DATE_FORMAT(l.Due_Date,"%Y-%m-%d"), ';
  $getExisting_SQL .= "datediff(l.Due_Date, curdate()), d.nextaction ";
  
  $getExisting_SQL .= "FROM tListEntries AS l ";
  $getExisting_SQL .= "LEFT JOIN tDescription AS d ON d.List_Id = l.ID, ";
  $getExisting_SQL .= "tPriority AS p, ";
  $getExisting_SQL .= "tStatus AS s ";
  
  $getExisting_SQL .= "WHERE l.status_Id = s.ID AND l.priority_Id = p.ID";

//  Test my SQL statement by uncommenting the following line  
//   echo $getExisting_SQL;
  
  
 // $getExisting_Query = mysql_query($getExisting_SQL);

	$getExisting_Query = mysqli_query($dbConnected,$getExisting_SQL);
	

echo "<table id=toDoTable>
						 
				 <tr>
					 <th id = 'priority'>
						Priority
					 </th>
					 <th id = 'status'>
						Status
					 </th>
					 <th id = 'subject'>
						Subject
					 </th>
					 <th id = 'dodate'>
						Due Date
					 </th>
					 <th id = 'action'>
						Action
					 </th>
				 </tr>";
	
	while($row = mysqli_fetch_array($getExisting_Query)) {				 
		
		echo "<tr>";
		echo 		"<td>" . $row['name'] . "</td>";		 
		echo "<td>". $row['status'] . "</td>";	
		echo "<td>". $row['subject'] . "</td>";	
		echo "<td>". $row['DATE_FORMAT(l.Due_Date,"%Y-%m-%d")'] . "</td>";	
		echo "<td></td>";
	}				 
	echo		"</table>";

  }
	{  // The form to add new HoneyDos
	
		{ // Select statement for Priority Field
	
			$fld_Priority_SQL = "SELECT Name ";
			$fld_Priority_SQL .= "FROM tPriority AS p ";
			$fld_Priority_SQL .= "ORDER BY p.Priority ASC";
			
		//	echo 'This is SQL for Priority Field ' .$fld_Priority_SQL. '<br />';
			
			$fld_Status_SQL = "SELECT Status ";
			$fld_Status_SQL .= "FROM tStatus ";
			$fld_Status_SQL .= "ORDER BY ID ASC";
			
		//	echo 'This is SQL for Status Field '.$fld_Status_SQL.'<br />';
			
		}
		{  //  Field Names for the Add Honey dos Table
		   //  First the Static Fields
			$fld_Subject = '<input type="text" name="Subject" size="50" maxlength="50"/>'; 
			
				// the Due_Date field is using jsDatePick  see code in index.php
			$fld_Due_Date = '<input type="text" name="Due_Date" size="12" id="inputField" />';
			
			//  And the selection fields
			//  The query for the Priority Field
			
			$priority_SQL_Query = mysqli_query($dbConnected,$fld_Priority_SQL);
			
			// echo 'Priority SQL Query result: '.$priority_SQL_Query.'<br />';
			
			$fld_Priority = '<select name="Priority">';
			
				while ($rowPriority = mysqli_fetch_array($priority_SQL_Query)) {
									    $priorityValue = $rowPriority['Name'];
									 //   if ($current_Priority == $priorityValue) { 
									 //   	$selectedFlag = " selected";
									 //   } else { 
									 //   	$selectedFlag = "";
									 //  }
									   $fld_Priority .= '<option>'.$priorityValue.'</option>';
									}
								
								//	mysqli_free_result($priority_SQL_Query);		
						
								$fld_Priority .= '</select>';
				
				//  The query for the Status Field
				$status_SQL_Query = mysqli_query($dbConnected,$fld_Status_SQL);
				
				$fld_Status = '<select name="Status">';
					
					while	($rowStatus = mysqli_fetch_array($status_SQL_Query)) {
										$statusValue = $rowStatus['Status'];
										$fld_Status .= '<option>'.$statusValue.'</option>';
										}
										
						//				mysqli_free_result($status_SQL_Query);
										
										$fld_Status .= '</select>';
		}								
		{  //  The input form using the defined variables
	
				echo "
					<form action=addHoneydo.php method='post'>
					<table id=listEntriesForm>
							<tr>
								 <td id = priority>
									$fld_Priority
								 </td>
								 <td id = status>
									$fld_Status
								 </td>
								 <td id = subject>
									$fld_Subject
								 </td>
								 <td id = dodate>
									$fld_Due_Date
								 </td>
								 <td id = action>";
					echo '			<input type="submit" value="Add" />';
					echo " </td>
							 </tr>
					</table>
					</form>	";
	
		}
	} 

}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   }


?>

</div>