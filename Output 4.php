<?php

	/**
	* Name:		Mikolaj Kaminski
	* Desc.:	Output no. 4 - Incidents in progress
	**/

	//Include server and database connection
	include "";

	//Select all records from Employee Table
	$TableNameEmployee = "EMPLOYEE";
	$SQLstring = "SELECT * FROM $TableNameEmployee ORDER BY `EmployeeID`";
	$QueryResultEmployee = mysqli_query($DBConnect, $SQLstring);
	//Checking for the exsitance of rows to display
	if (mysqli_num_rows($QueryResultEmployee) == 0)
	{
		echo "<p>There are no employees in the system.</p>";
	}
	//Display employees in TABLE HEADS with their incidents
	else
	{
		echo "<table border='1'>";
		while($Row = mysqli_fetch_assoc($QueryResultEmployee))
		{
			echo "<tr>";
			echo "<th>{$Row['EmployeeID']}</th>";
			echo "<th colspan=\"2\">{$Row['EmployeeName']}</th>";
			echo "<th colspan=\"2\">{$Row['EmployeeSurname']}</th>";
			echo "<th colspan=\"2\">{$Row['Picture']}</th>";
			echo "</tr>";

			//Select incident records to display
			$TableNameIncident = "INCIDENT";
			$TableNameStatus = "INCIDENT_STATUS";
			$TableNameStatusType = "STATUS";
			$TableNameIncidentType = "INCIDENT_TYPE";
			$SQLstring = "SELECT $TableNameIncident.`IncidentID`, `ClientID`, `DateStart`, `Description`, `IncidentTypeName`, `Priority`, `StatusName`, MAX(`Date`) FROM $TableNameIncident, $TableNameStatus, $TableNameStatusType, $TableNameIncidentType WHERE `EmployeeID` = $Row['EmployeeID'], $TableNameIncident.`IncidentID` IS $TableNameStatus.`IncidentID`, $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID`, $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` GROUP BY $TableNameStatus.`IncidentID`";
			$QueryResultIncident = mysqli_query($DBConnect, $SQLstring);
			//Checking for the exsitance of rows to display
			if (mysqli_num_rows($QueryResultIncident) == 0)
			{
				echo "<tr><td colspan=\"7\">The employee has no assigned incidents.</td></tr>";
			}
			//Display open incidents in TABLE DATA for the employee
			else
			{
				echo "<tr><td>IncidentID</td><td>ClientID</td><td>Start Date</td><td>Description</td><td>Type</td><td>Priority</td><td>Status</td></tr>";
				while ($IncidentRow = mysqli_fetch_assoc($QueryResultIncident))
				{
					echo "<tr>";
					echo "<td>{$IncidentRow['IncidentID']}</td>";
					echo "<td>{$IncidentRow['ClientID']}</td>";
					echo "<td>{$IncidentRow['DateStart']}</td>";
					echo "<td>{$IncidentRow['Description']}</td>";
					echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
					echo "<td>{$IncidentRow['Priority']}</td>";
					echo "<td>{$IncidentRow['StatusName']}</td>";
					echo "</tr>";
				}
			}
		}
		echo "</table>";
	}
	mysqli_free_result($QueryResult);

?>