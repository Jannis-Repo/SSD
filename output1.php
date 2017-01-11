
<?php
	/* Sona Gautam 
	* Output1 -Number of Incidents */

	//Need to include database connection 
	require ('');

	//Incidentid
	$IncidentID = mysqli_connect($DBConnect, $_GET["Incidentid"]);

	// for Year
	$sql = "SELECT COUNT(IncidentID) FROM Incident WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 365 DAY) and DATE(Now())";
	$result = mysqli_query($DBConnect, $sql);
	$Year = mysqli_fetch_assoc($result);

	//for month
	$sql2 = "SELECT COUNT(IncidentID) FROM INCIDENT WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 31 DAY) and DATE(Now())";
	$result2 = mysqli_query($DBConnect, $sql2);
	$Month = mysqli_fetch_assoc($result2);

	//for Week
	$sql3 = "SELECT COUNT(IncidentID) FROM INCIDENT WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 7 DAY) and DATE(Now())";
	$result3 = mysqli_query($DBConnect, $sql3);
	$Week = mysql_fetch_assoc($result3);

	$to = $Employees['Incident'];
	$subject = 'Showing Number of incident per week,month,year';
	$from = 'Emailoofclients';
	$headers = 'Content-type: text/html';
?>

  