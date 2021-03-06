<!DOCTYPE html>
<head>
<title>HoneyDos Edit Page</title>
<meta name="generator" content="Bluefish 2.2.6" >
<meta name="author" content="Linden Thomas" >
<meta name="date" content="2014-05-19T00:52:56-0600" >
<meta name="copyright" content="Linn Thomas Digital">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
<link rel="stylesheet" type="text/css" href="honeydo.css" />
<link rel="stylesheet" type="text/css" media="all" href="jsdatepick/jsDatePick_ltr.css" />
<link rel="stylesheet" type="text/css" media="all" href="jsdatepick/jsDatePick_ltr.min.css" />
<!-- 
	This is the jsDatePick for the calendar
	Copyright 2009 Itamar Arjuan
	jsDatePick is distributed under the terms of the GNU General Public License.
	
	****************************************************************************************
-->
<script type="text/javascript" src="jsdatepick/jquery.1.4.2.js"></script>
<script type="text/javascript" src="jsdatepick/jsDatePick.full.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%Y-%m-%d",
			weekStartDay:"0"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:18,
				year:2014
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%Y-%m-%d",
			imgPath:"img/",
			weekStartDay:0*/
		});
	};
</script>
<script language="JavaScript" type="text/javascript">
		function checkDelete(){
		    return confirm('Are you sure?');
		}
</script>
</head>
<body>
	<div id="container">	
		<div id="content" style="height:700px">

<?php

	include('header.html'); 
	
/*  File Documentation

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
	
  // Check for button click and create variable
  if (isset($_POST["saveClicked"])){ $saveClicked = $_POST['saveClicked']; };
  
	if(isset($_GET["listID"])){ $listID = $_GET['listID']; };
 
 //  echo "This is the listID variable: $listID <br />";
	
	{
	 
	 //Check for return variable and if it is set unset it
	 if(isset($saveClicked)) {
		// echo 'saveClicked is set with value '.$saveClicked.' <br />';
	 	
	 	unset($saveClicked);
	 	
	 	//  Then Post the Variables from the form that is passing back to this script
	 	
		$listID = $_POST['listID']	; 	
	 	$categoryID = $_POST['categoryID'];
   		$DueDate = $_POST['Due_Date'];
   		$priority_Id = $_POST['priority_Id'];
   		$statusID = $_POST['statusID'];
   		$description = $_POST['description'];
   		$nextAction = $_POST['nextAction'];
   		$prerequisites = $_POST['prerequisites'];
   		$reqMaterials = $_POST['req_Materials'];
   		
   		// Insert the values from the form into the database
   		
   		$editListEntries_SQLupdate = "UPDATE tListEntries SET ";
   		$editListEntries_SQLupdate .= "category_Id = '".$categoryID."', ";
   		$editListEntries_SQLupdate .= "Due_Date = '".$DueDate."', ";
   		$editListEntries_SQLupdate .= "priority_Id = '".$priority_Id."', ";
   		$editListEntries_SQLupdate .= "status_Id = '".$statusID."' ";
   		$editListEntries_SQLupdate .= "WHERE ID = '".$listID."' "; 	
   		
   		$editDescription_SQLupdate = "UPDATE tDescription SET ";
   		$editDescription_SQLupdate .= "Description = '".$description."', ";
   		$editDescription_SQLupdate .= "NextAction = '".$nextAction."', ";
   		$editDescription_SQLupdate .= "Prerequisites = '".$prerequisites."', ";
   		$editDescription_SQLupdate .= "Req_Materials = '".$reqMaterials."' ";
   		$editDescription_SQLupdate .= "WHERE List_Id = '".$listID."' "; 
   		
   		mysqli_query($dbConnected, $editListEntries_SQLupdate);
   		mysqli_query($dbConnected, $editDescription_SQLupdate);
   				
	 	}  // End of isset $saveClicked
	 }

		

	{  // Create a record in the tDescription Table with the ID from the tListEntries Table
	   //  First I need to check and see if it already exists
	   
	   $listIDexists = mysqli_query($dbConnected,"SELECT List_Id FROM tDescription WHERE List_Id = $listID");
	   $num_rows = mysqli_num_rows($listIDexists);
	   
	  			// echo "This is the Number of Rows variable: $num_rows <br />";
	   
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
   
   $editHoneyDos_SQL = "SELECT c.ID, c.Category, d.Description, d.ID, d.List_Id, d.NextAction, ";
   $editHoneyDos_SQL .= "d.Prerequisites, d.Req_Materials, category_Id, priority_Id, status_Id, Subject, ";
   $editHoneyDos_SQL .= "p.ID, p.Name, p.Priority, s.ID, s.Status, ";
	$editHoneyDos_SQL .= 'DATE_FORMAT(Due_Date,"%Y-%m-%d"), ';
	$editHoneyDos_SQL .= 'DATE_FORMAT(Create_Date, "%Y-%m-%d"), ';
	$editHoneyDos_SQL .= 'DATE_FORMAT(Last_Modified, "%Y-%m-%d"), ';
	$editHoneyDos_SQL .= 'DATE_FORMAT(Start_Date, "%Y-%m-%d") ';
   $editHoneyDos_SQL .= "FROM tListEntries AS l ";
	$editHoneyDos_SQL .= "JOIN tDescription AS d ON d.List_Id = l.ID ";
	$editHoneyDos_SQL .= "JOIN tPriority AS p ON p.ID = l.priority_id  ";
	$editHoneyDos_SQL .= "JOIN tStatus AS s ON s.ID = l.status_Id ";
	$editHoneyDos_SQL .= "JOIN tCategory AS c ON c.ID = l.category_Id ";
   $editHoneyDos_SQL .= "WHERE l.ID=$listID ";
  
   
   			//  echo "This is the editHoneyDos SQL Statement ".$editHoneyDos_SQL." <br />";
   
   
   $editHoneyDos_Query = mysqli_query($dbConnected, $editHoneyDos_SQL);
   
		   while($rowEdit=mysqli_fetch_array($editHoneyDos_Query)) {
		   		$categoryID = $rowEdit['category_Id'];
		   		$categoryName = $rowEdit['Category'];
		   		$createDate = $rowEdit['DATE_FORMAT(Create_Date, "%Y-%m-%d")'];
		   		$DueDate = $rowEdit['DATE_FORMAT(Due_Date,"%Y-%m-%d")'];
		   		$lastModified = $rowEdit['DATE_FORMAT(Last_Modified, "%Y-%m-%d")'];
		   		$priorityID = $rowEdit['priority_Id'];
		   		$priorityName = $rowEdit['Name'];
		   		$startDate = $rowEdit['DATE_FORMAT(Start_Date, "%Y-%m-%d")'];
		   		$statusID = $rowEdit['status_Id'];
		   		$statusName = $rowEdit['Status'];
		   		$subject = $rowEdit['Subject'];
		   		$description = $rowEdit['Description'];
		   		$nextAction = $rowEdit['NextAction'];
		   		$prerequisites = $rowEdit['Prerequisites'];
		   		$reqMaterials = $rowEdit['Req_Materials'];
   
 	  }	
 	  
 	  mysqli_free_result($editHoneyDos_Query);
 	  
 	  // Now I will do queries for the drop downs. I have these from the previous SELECT but in a different array
 	  // I'm not sure if I have to pull them again... but it seems like I do
 	  
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
		{	//  And the selection drop downs
			//  The query for the Priority Field
			
			$priority_SQL_Query = mysqli_query($dbConnected,$fld_Priority_SQL);
			
			// echo 'Priority SQL Query result: '.$priority_SQL_Query.'<br />';
			
			$fld_Priority = '<select name="priority_Id">';
			
				while ($rowPriority = mysqli_fetch_array($priority_SQL_Query)) {
									    $dd_priorityValue = $rowPriority['Name'];
									    $dd_priorityID = $rowPriority['ID'];
									    
									    if($dd_priorityID == $priorityID) {
									    	$selectedFlag = " selected";
										    } else { 
										    	$selectedFlag = "";
										    }
									 
									   $fld_Priority .= '<option value='.$dd_priorityID.' '.$selectedFlag.'>'.$dd_priorityValue.'</option>';
									}
								
								mysqli_free_result($priority_SQL_Query);		
						
								$fld_Priority .= '</select>';
				
				//  The query for the Status Field
				$status_SQL_Query = mysqli_query($dbConnected,$fld_Status_SQL);
				
				$fld_Status = '<select name="statusID">';
					
					while	($rowStatus = mysqli_fetch_array($status_SQL_Query)) {
										$dd_statusValue = $rowStatus['Status'];
										$dd_statusID= $rowStatus['ID'];
										
										if($dd_statusID == $statusID) {
											$selectedFlag = "selected";
											} else {
												$selectedFlag = "";
											}
											
										$fld_Status .= '<option value='.$dd_statusID.' '.$selectedFlag.'>'.$dd_statusValue.'</option>';
										}
										
										mysqli_free_result($status_SQL_Query);
										
										$fld_Status .= '</select>';
										
		//  The query for the Category Field
				$category_SQL_Query = mysqli_query($dbConnected,$fld_Category_SQL);
				
				$fld_Category = '<select name="categoryID">';
					
					while	($rowCategory = mysqli_fetch_array($category_SQL_Query)) {
										$dd_categoryValue = $rowCategory['Category'];
										$dd_categoryID= $rowCategory['ID'];
										
										if($dd_categoryID == $categoryID) {
											$selectedFlag = "selected";
											}  else {
												$selectedFlag = "";											
											}
										$fld_Category .= '<option value='.$dd_categoryID.' '.$selectedFlag.'>'.$dd_categoryValue.'</option>';
										}
										
										mysqli_free_result($category_SQL_Query);
										
										$fld_Category .= '</select>';
										
					$fld_DueDate = '<input type="datetime" name="Due_Date" size="12" id="inputField" value="'.$DueDate.'" />';
		}
 
	 //  This is the form for editing the HoneyDos
		//   Set Variables for the existing entries
	
		$fld_listID = '<input type="hidden" name="listID" value="'.$listID.'"/>';  	
	  	$fld_saveClicked = '<input type="hidden" name="saveClicked" value="1"/>';

  	
	echo '<form name="postHoneyDos" action="'.$thisScriptName.'" method="post">';
  	// echo '<form name="postHoneyDos" action="testForm.php" method="post">';	
  	echo $fld_saveClicked;
  	echo $fld_listID;
 
   	echo '<table id=listEntriesEdit>';
	echo 		'<tr>';
   	echo			'<td value='.$listID.' id=editHDsubject colspan="6">Honey Do: '.$subject. ' </td>';   	
   	echo		'</tr>'; 
   	echo		'<tr>';
   	echo			'<th id=category>';
   	echo				'Category';
   	echo			'</th>'; 
   	echo			'<th id=createDate>';
   	echo				'Date Created';
   	echo			'</th>';
   	echo			'<th id=dodate>';
   	echo				'Date Due';
   	echo			'</th>';
  	echo			'<th id=lastModified>';
   	echo				'Last Modified';
   	echo			'</th>';
   echo			'<th id=status>';
   	echo				'Status';
   	echo			'</th>';
   	echo			'<th id=priority>';
   	echo				'Priority';
   	echo			'</th>';
   	echo	'</tr>';
   	echo	'<tr>'; 
   	echo			'<td id = category>'.$fld_Category.'</td>';
   	echo			'<td>'.$createDate.'</td>';
   	echo			'<td id = dodate>'.$fld_DueDate.'</td>';
   	echo			'<td>'.$lastModified.'</td>';
   	echo			'<td id = status>'.$fld_Status.'</td>';
   	echo			'<td id = priority>'.$fld_Priority.'</td>';
   	echo		'</tr>';
   echo		'<tr>
 				 			<th colspan = "2">Description</th>
 				 			<th colspan = "2">Next Action</th>
					</tr>';	
   	echo			'<tr>';
   	echo 			'<td colspan = "2" align="center">
   							<textarea type="text" value= "'.$description.'" name="description" wrap="soft" placeholder="Add Description Here">'.$description.'</textarea>
   						</td>';
   	echo			'<td colspan = "2" align="center">
   						<textarea type="text" value= "'.$nextAction.'" name="nextAction" wrap="soft" placeholder="Add What to do next Here">'.$nextAction.'</textarea>
   						</td>';
   	echo 		'</tr>';
   echo		'<tr>
 				 			<th colspan = "2">Prerequisites</th>
 				 			<th colspan = "2">Materials</th>
					</tr>';	
   	echo 		'<tr>';
   	echo			'<td colspan = "2" align="center">
   						<textarea type="text" value= "'.$prerequisites.'" name="prerequisites" wrap="soft" placeholder="Prerequisites">'.$prerequisites.'</textarea>
   						</td>';
   	echo			'<td colspan = "2" align="center">
   						<textarea type="text" value= "'.$reqMaterials.'" name="req_Materials" wrap="soft" placeholder="Materials">'.$reqMaterials.'</textarea>
   						</td>';
   echo			'<td>
   							<button  type="submit">Save Changes</button>
   						</td>';
   	echo 		'</tr>';
   	echo '</table>';
   
   
   echo '</form>';
   
}
	

 echo '<br /><a href="index.php">Go Back to Home </a>';
 
 
}  //  End of Connection Trap
   else { echo "You're not connected to the Database Dummy!";
   
    }

	include('footer.html'); 
?>

			</div>
		</div>
	</body>
</html>