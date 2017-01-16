<?php
/**
* Name:	    Jannis Luegering
* Desc.:	Version 1 of Input_4.php
**/

/**
* Name:	    Jannis Luegering
* Desc.:    Include the necessary database variables.
**/
include "classes/database.class.php";

/**
* Name:	    Jannis Luegering
* Desc.:    Fill the variables with data from selected incident.
**/
$incidentID = stripslashes($_POST['incidentID']);
$employeeID = stripslashes($_SESSION['employeeID']);

if (isset($_POST['submit']))
{
    /**
    * Name:	    Jannis Luegering
    * Desc.:    Fill the variables with the form data.
    **/
    $solution = stripslashes($_POST['solution']);
    $statusID = stripslashes($_POST['statusID']);

    /**
    * Name:	    Jannis Luegering
    * Desc.:    Insert data for the status
    **/
	$tableName = "INCIDENT_STATUS";
	$SQLstring = "INSERT INTO $tableName VALUES(NULL, '$incidentID', '$employeeID', $statusID, $solution, NOW())";
	mysqli_query($DBConnect, $SQLstring) OR DIE ("Unable to change status!");
	echo "<p>The status of incident " . $incidentID . " has been successfully changed.</p>";
}
?>

<html>
    <head>
    </head>

    <body>
        <form action="Input_3.php" method="post">
            <label>Solution / Description: </label>
            <textarea name="solution" rows="8" cols="16" maxlength="300"></textarea>

            <label>Status: </label>
            <select name="statusID">
                <option value="1">New</option>
                <option value="2">Pending</option>
                <option value="3">Forwarded to Engineer</option>
                <option value="4">Forwarded to Account Manager</option>
                <option value="5">Resolved</option>
                <option value="6">Closed</option>
            </select>

            <input type="hidden" name="incidentID" value="<?php echo $incidentID; ?>">
            <input type="submit" name="submit">
        </form>
    </body>
</html>
