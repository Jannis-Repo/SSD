<?php

	/**
	* Name:		Mikolaj Kaminski
	* Desc.:	Input no. 7 - Assign Incident PHP
	**/

	//Include server and database connection
	include "";

	//Add input to database server
	//Setting variables to $POST data
	$IncidentID = stripslashes($_POST['IncidentID']);
	$EmployeeID = stripslashes($_POST['EmployeeID']);
	//Insert data
	$TableName = "INCIDENT_STATUS";
	$SQLstring = "INSERT INTO $TableName VALUES(NULL, '$IncidentID', '$EmployeeID', NULL, NULL, NULL)";
	mysqli_query($DBConnect, $SQLstring)
	OR DIE ("<p>Unable to Assign Incident.</p>");
	echo "<p>The incident has been assigned!</p>";

?>


<!--
	Name:	Mikolaj Kaminski
	Desc.:	Input no. 7 - Assign Incident FORM
-->

<form method="POST" action="">
	<?php

		//Include server and database connection
		include "";

		//INCIDENT ID FORM
		echo "<p>Incident ID: ";

		//Selecting all unfinished Incident ID's from INCIDENT table
		$TableNameIncident = "INCIDENT";
		$TableNameStatus = "INCIDENT_STATUS";
		$SQLstring = "SELECT * FROM $TableNameIncident WHERE `IncidentID` IS (SELECT `IncidentID` FROM $TableNameStatus WHERE `StatusID` BETWEEN 1 AND 5) ORDER BY `IncidentID` GROUP BY `IncidentID`";
		$QueryResult = mysqli_query($DBConnect, $SQLstring);
		//Checking for the exsitance of rows to display
		if (mysqli_num_rows($QueryResult) == 0)
		{
			echo "There are no incidents that are active.";
		}
		//Display returned records in an <select>
		else
		{
			echo "<select name=\"IncidentID\">";
			while($Row = mysqli_fetch_assoc($QueryResult))
			{
				echo "<option value=\"{$Row['IncidentID']}\">{$Row['IncidentID']}</option>";
			}
			echo "</select>";
		}
		mysqli_free_result($QueryResult);
		echo "</p>";

		//EMPLOYEE SELECT FORM
		echo "<p>Employee ID: ";

		//Selecting all Employees ID's from EMPLOYEE table
		$TableName = "EMPLOYEE";
		$SQLstring = "SELECT * FROM $TableName";
		$QueryResult = mysqli_query($DBConnect, $SQLstring);
		//Checking for the exsitance of rows to display
		if (mysqli_num_rows($QueryResult) == 0)
		{
			echo "There are no employees in the system.";
		}
		//Display returned records in an <select>
		else
		{
			echo "<select name=\"EmployeeID\">";
			while($Row = mysqli_fetch_assoc($QueryResult))
			{
				echo "<option value=\"{$Row['EmployeeID']}\">{$Row['EmployeeID']} {$Row['EmployeeName']} {$Row['EmployeeSurname']}</option>";
			}
			echo "</select>";
		}
		mysqli_free_result($QueryResult);
		echo "</p>";	

	?>
</form>