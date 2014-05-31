<!DOCTYPE html>

<html>
	<head>
		<script>
			function loadXMLDoc()
			{
				var xmlhttp;
				if (window.XMLHTTPRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHTTPRequest();
					}
				else
					{//code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
				xmlhttp.onreadystatechange=function()
					{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
						}
					}
			xmlhttp.open("GET","ajax_info.txt");
			xmlhttp.send();
			}
		</script>
	</head>
<body>
	<div id="myDiv"><h2> Let AJAX change this text</h2></div>
	<button type="button" onclick="loadXMLDoc() ">Change Content</button>
</body>
</html>
