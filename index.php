<!DOCTYPE html>
<html>
<head>
<title>HoneyDos Start Page</title>
<meta name="generator" content="Bluefish 2.2.6" >
<meta name="author" content="Linden Thomas" >
<meta name="date" content="2014-05-15T22:47:50-0600" >
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
			dateFormat:"%Y-%m-%d"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
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

<?php 	include('header.html'); 
				
				include('content.php');

				include('footer.html'); 
				
?>

</div>
</body>
</html>