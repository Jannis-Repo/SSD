<?php

	/**
	* Name:		Matthias Huetten
	* Desc.:	Output no. 3 - List of Incidents
	**/

	//Include server and database connection
	include "";

	//Select all records from Incident Table
		$TableNameIncident = "INCIDENT";
		$SQLstring = "SELECT * FROM $TableNameIncident ORDER BY `IncidnetID`";
		$QueryResultIncident = mysqli_query($DBConnect, $SQLstring);
		
		
	//Checking for the exsitance of rows to display
		if (mysqli_num_rows($QueryResultIncident) == 0)
		{
			echo "<p>There are no Incidents in the system.</p>";
		}
		
	//Display incidents in TABLE HEADS which are in progress
		else
		{
			echo "<table border='1'>";
			while($Row = mysqli_fetch_assoc($QueryResultIncident))
			{
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
						echo "<tr><td colspan=\"6\">No incidents in progress.</td></tr>";
					}
				
				//Display open progressing incidents in TABLE DATA for the all kinds of User
					else
					{
						echo "<tr><td>IncidentID</td><td>Description</td><td>Solution</td><td>Type</td><td>Status</td><td>StartDate</td></tr>";
						while ($IncidentRow = mysqli_fetch_assoc($QueryResultIncident))
						{
							echo "<tr>";
							echo "<td>{$IncidentRow['IncidentID']}</td>";
							echo "<td>{$IncidentRow['Description']}</td>";
							echo "<td>{$IncidentRow['Solution']}</td>";
							echo "<td>{$IncidentRow['Type']}</td>";
							echo "<td>{$IncidentRow['Status']}</td>";
							echo "<td>{$IncidentRow['StartDate']}</td>";
							echo "</tr>";
						}
					}
			}
			echo "</table>";
		}
		mysqli_free_result($QueryResult);

?>