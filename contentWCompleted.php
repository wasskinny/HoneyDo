<div id="content" style="height:400px">

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

	// This is the name of the script
	$thisScriptName = 'index.php';
	
	//  Define variable for Sorting Columns in HoneyDo Table
	
	if (!isset($orderClause)) {$orderClause = "l.Due_Date";}
	
	
	
	{  // Pull the existing HoneyDo's from the database
  
  $getExisting_SQL = "Select l.ID, p.name, l.subject, s.status, c.category, ";
  $getExisting_SQL .= 'DATE_FORMAT(l.Due_Date,"%Y-%m-%d"), ';
  $getExisting_SQL .= "datediff(l.Due_Date, curdate()), d.nextaction ";
  
  $getExisting_SQL .= "FROM tListEntries AS l ";
  $getExisting_SQL .= "LEFT JOIN tDescription AS d ON d.List_Id = l.ID, ";
  $getExisting_SQL .= "tPriority AS p, ";
  $getExisting_SQL .= "tStatus AS s, ";
  $getExisting_SQL .= "tCategory As c ";
  
  $getExisting_SQL .= "WHERE l.status_Id = s.ID AND l.priority_Id = p.ID AND l.category_Id = c.ID ";
  
  $getExisting_SQL .= "ORDER BY ";
  $getExisting_SQL .= $orderClause;
  

//  Test my SQL statement by uncommenting the following line  
//   echo $getExisting_SQL;
  
  
 // $getExisting_Query = mysql_query($getExisting_SQL);

	$getExisting_Query = mysqli_query($dbConnected,$getExisting_SQL);
	
	}
	{  // Build a table to output and edit the honeydo list
	
	// Variables to Sort by header row
	
	$header_Priority = '<a href="'.$thisScriptName.'?orderClause=p.name%20DESC"><span class="tableHeader">Priority</span></a>';
	$header_Status = '<a href="'.$thisScriptName. '?orderClause=s.status"><span class="tableHeader">Status</span></a>';
	$header_Category = '<a href="'.$thisScriptName. '?orderClause=c.category"><span class="tableHeader">Category</span></a>';
	$header_Subject = '<a href="'.$thisScriptName. '?orderClause=l.subject"><span class="tableHeader">Subject</span></a>';
	$header_DoDate = '<a href="'.$thisScriptName. '?orderClause=l.Due_Date"><span class="tableHeader">Due Date</span></a>';
	  
      // The header row for the table
      
		echo "<table id=toDoTable>
								 
						 <tr>
							 <th id = 'priority'>
								$header_Priority
							 </th>
							 <th id = 'status'>
								$header_Status
							 </th>
							 <th id = 'category'>
							 	$header_Category
							 </th>
							 <th id = 'subject'>
								$header_Subject
							 </th>
							 <th id = 'dodate'>
								$header_DoDate
							 </th>
							 <th id = 'action'>
								Action
							 </th>
						 </tr>";
	
	$indx = 0	;
	$numList = 0;
	
	while($row = mysqli_fetch_array($getExisting_Query)) {	
	
	// So we are going to build in some variables so we can pass them to an update form...
	
	$listArray[$indx]['ID'] = $row['ID'];
	$listArray[$indx]['name'] = $row['name'];
	$listArray[$indx]['status'] = $row['status'];
	$listArray[$indx]['category'] = $row['category'];
	$listArray[$indx]['subject'] = $row['subject'];
	$listArray[$indx]['date'] = $row['DATE_FORMAT(l.Due_Date,"%Y-%m-%d")'];
	
		$indx++;
	}				 
	
	if (isset($listArray)) {$numList = sizeof($listArray);	};
	
	
	// The table entries
	
	for ($indx = 0; $indx < $numList; $indx++) {
									$thisID = $listArray[$indx]['ID'];
		 			// This is for Delete and Completion Links ... will make it prettier later
		 			//				I'm going to edit from the Subject Field
		 			//				$listEditLink = '<a href="honeydoEditForm.php?listID='.$thisID.'">E</a> ';
		 							$listEditLink = '<a href="deleteHoneyDo.php?listID='.$thisID.'" onclick="return checkDelete()">Delete</a> ';
		 							
									echo "<tr>";
									
									echo		"<td>".$listArray[$indx]['name']."</td>";
									echo		"<td>".$listArray[$indx]['status']."</td>";
									echo		"<td>".$listArray[$indx]['category']."</td>";
									echo		'<td><a href="editHoneyDo.php?listID='.$thisID.'">'.$listArray[$indx]['subject'].'</a></td>';
									echo		"<td>".$listArray[$indx]['date']."</td>";
									echo		"<td>".$listEditLink."</td>";
									echo "</tr>";			
	}
	echo		"</table>";
	
	$numberEntries = $indx;
	
	echo "<br />There are ".$numberEntries." active HoneyDos";

  }
	{  // The form to add new HoneyDos
	
		{ // Select statement for Priority Field
	
			$fld_Priority_SQL = "SELECT Name, Priority, ID ";
			$fld_Priority_SQL .= "FROM tPriority AS p ";
			$fld_Priority_SQL .= "ORDER BY p.Priority ASC";
			
		//	echo 'This is SQL for Priority Field ' .$fld_Priority_SQL. '<br />';
			
			$fld_Status_SQL = "SELECT Status, ID ";
			$fld_Status_SQL .= "FROM tStatus ";
			$fld_Status_SQL .= "ORDER BY ID ASC";
			
		//	echo 'This is SQL for Status Field '.$fld_Status_SQL.'<br />';
		
			$fld_Category_SQL = "SELECT Category, ID ";
			$fld_Category_SQL .= "FROM tCategory ";
			$fld_Category_SQL .= "ORDER BY ID ASC";
			
		//	echo 'This is SQL for Status Field '.$fld_Status_SQL.'<br />';
			
		}
		{  //  Field Names for the Add Honey dos Table
		   //  First the Static Fields
			$fld_Subject = '<input type="varchar" name="Subject" size="50" maxlength="50"/>'; 
			
				// the Due_Date field is using jsDatePick  see code in index.php
			$fld_Due_Date = '<input type="datetime" name="Due_Date" size="12" id="inputField" />';
			
			//  And the selection fields
			//  The query for the Priority Field
			
			$priority_SQL_Query = mysqli_query($dbConnected,$fld_Priority_SQL);
			
			// echo 'Priority SQL Query result: '.$priority_SQL_Query.'<br />';
			
			$fld_Priority = '<select name="Priority">';
			
				while ($rowPriority = mysqli_fetch_array($priority_SQL_Query)) {
									    $priorityValue = $rowPriority['Name'];
									    $priorityID = $rowPriority['ID'];
									 
									   $fld_Priority .= '<option value='.$priorityID.'>'.$priorityValue.'</option>';
									}
								
								//	mysqli_free_result($priority_SQL_Query);		
						
								$fld_Priority .= '</select>';
				
				//  The query for the Status Field
				$status_SQL_Query = mysqli_query($dbConnected,$fld_Status_SQL);
				
				$fld_Status = '<select name="Status">';
					
					while	($rowStatus = mysqli_fetch_array($status_SQL_Query)) {
										$statusValue = $rowStatus['Status'];
										$statusID= $rowStatus['ID'];
										$fld_Status .= '<option value='.$statusID.'>'.$statusValue.'</option>';
										}
										
						//				mysqli_free_result($status_SQL_Query);
										
										$fld_Status .= '</select>';
										
		//  The query for the Category Field
				$category_SQL_Query = mysqli_query($dbConnected,$fld_Category_SQL);
				
				$fld_Category = '<select name="Category">';
					
					while	($rowCategory = mysqli_fetch_array($category_SQL_Query)) {
										$categoryValue = $rowCategory['Category'];
										$categoryID= $rowCategory['ID'];
										$fld_Category .= '<option value='.$categoryID.'>'.$categoryValue.'</option>';
										}
										
						//				mysqli_free_result($category_SQL_Query);
										
										$fld_Category .= '</select>';
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
								 <td id = category>
								 	$fld_Category
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