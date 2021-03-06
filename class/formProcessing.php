<?php
/**
 * Created by PhpStorm.
 * User: Jannis
 * Date: 1/13/2017
 * Time: 11:19 AM
 */

session_start();
include 'dbConnection.php';
$method = $_POST['method'];
if ($method == 'addEmployee') {
  
    //Variables
    $firstName = stripslashes($_POST['firstName']);
    $lastName = stripslashes($_POST['lastName']);
    $email = stripslashes($_POST['email']);
    $password = hash('whirlpool', stripslashes($_POST['password']));
    $authorisation = stripslashes($_POST['authorisation']);
    $pictureURL = 'employeePictures/' . $_FILES['pictureUpload']['name'];

    /**
     * Name:	    Jannis Luegering
     * Desc.:	    Insert data for the employee.
     **/
  
    $tableName = "EMPLOYEE";
    $SQLstring = "INSERT INTO $tableName VALUES(NULL, '$authorisation', '" . utf8_encode($firstName) . "', '" . utf8_encode($lastName) . "', '$pictureURL', '$email', '$password')";

    $result = mysqli_query($DBConnection, $SQLstring);

    if ($result)
    {
        /**
         * Name:	    Jannis Luegering
         * Desc.:	    Move picture to the right directory to store it.
         **/
        move_uploaded_file($_FILES['pictureUpload']['tmp_name'], 'employeePictures/' . $_FILES['pictureUpload']['name']);
        echo "<p>The employee has been created successfully.</p>";
    }
    else
    {
        echo "<p>There was a problem with creating the employee</p>".mysqli_error($DBConnection);
    }
}
else if ($method == 'login')
{
    //Variables
    $email = stripslashes($_POST['email']);
    $password = hash('whirlpool', stripslashes($_POST['password']));

    $tableName = "`EMPLOYEE`, `AUTHORISATION`";
    $sqlString = "SELECT * FROM $tableName WHERE `EMPLOYEE`.`EmployeeEmail` = '$email' AND `EMPLOYEE`.`EmployeePassword`= '$password'";
    $result = mysqli_query($DBConnection, $sqlString) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['loggedIn'] = true;
        $_SESSION['employeeID'] = $row['EmployeeID'];
        $_SESSION['auth'] = $row['Level'];

        header('Location: http://www.stenden.protonbytez.com/');
        exit;
    }
    else
    {
        mysqli_free_result($result);
        $tableName = "`USER`";
        $sqlString = "SELECT * FROM $tableName WHERE `UserEmail` = '$email' AND `UserPassword`= '$password'";
        $result = mysqli_query($DBConnection, $sqlString) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
			/*
			/* Anass Houlout
			/* Description: Check License
			*/
			$cID = $row['ClientID'];
			$licenseSql = mysqli_query($DBConnection, "SELECT * FROM LICENSE WHERE ClientID = '$cID'");
			$licenseResult = mysqli_fetch_assoc($licenseSql);
			$exp_date = strtotime(str_replace('-', '/', $licenseResult['ExpiryDate']));
			if(time() > $exp_date)
			{
				$_SESSION["error"] = "Your license has expired, please notify your manager.";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			} else {
				$_SESSION['loggedIn'] = true;
				$_SESSION['employeeID'] = $row['UserID'];
				$_SESSION['auth'] = 0;

				mysqli_free_result($result);

				header('Location: http://www.stenden.protonbytez.com/');
				exit;
			}
        }
        else
        {
            echo '<p>E-Mail or Password wrong.</p>';
            echo '<p>Please try again.</p>';
        }
    }
} elseif($method == 'addUser') {
    /*
    * Name: Anass Houlout
    * Desc: Add a new User
    */

    // Get the POST data
    $name = stripslashes($_POST["name"]);
    $surname = stripslashes($_POST["surname"]);
    $email = stripslashes($_POST["email"]);
    $password = hash('whirlpool', $_POST["password"]);

    // Client ID
    $clientId = $_POST["company"];

    $role = stripslashes($_POST["role"]);
    $phonenumber = stripslashes($_POST["phonenumber"]);

    // execute sql query
    $sql = mysqli_query($DBConnection, "INSERT INTO USER VALUES ('', '$clientId', '$name', '$surname', '$email', '$password', '$role', '$phonenumber')");
    if($sql)
    {
        echo '<div class="alert alert-success"><strong>Success!</strong> User added successfully.</div>';
    } else {
        echo 'There was a system error. please contact the technical support';
    }
} elseif($method == 'addClient') {
    /*
    * Name: Anass Houlout
    * Desc: Add a new client
    */
    // Get the POST data
    $name = stripslashes($_POST["name"]);
    $address = stripslashes($_POST["address"]);
    $email = stripslashes($_POST["email"]);
    $type = $_POST["type"]; // Client Type ID

    // execute sql query
    $sql = mysqli_query($DBConnection, "INSERT INTO CLIENT VALUES ('', '$name', '$address', '$email', '$type')");
    if($sql)
    {
		$_SESSION['success'] = "Client added successfully.";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo 'There was a system error. please contact the technical support';
    }
} elseif($method == "addIncident") {
    /*
    * Name: Anass Houlout
    * Desc: Add a new incident via the user interface
    */

    // Get the POST data
    $userID = stripcslashes($_POST["userID"]);
    $description = mysqli_real_escape_string($DBConnection, $_POST["description"]);
    $type = stripslashes($_POST["type"]);
    // Date 
    $date = date('Y-m-d');
    // Default priority value
    $priority = 1;
    // execute sql query - INCIDENT table
    $sql = mysqli_query($DBConnection, "INSERT INTO INCIDENT VALUES ('', '$userID', '$type', '$date', NULL, '$description', '$priority')");
    if($sql)
    {
        $incidentID = mysqli_insert_id($DBConnection);
        $status = 1; // Default status (New = 1)
        $status_date = date("Y-m-d H:i:s");
        // execute sql query - INCIDENT_STATUS table
        $sql2 = mysqli_query($DBConnection, "INSERT INTO INCIDENT_STATUS VALUES ('', '$incidentID', '', '$status', '', '$status_date')");
        if($sql2)
        {
            $_SESSION['success'] = "Incident added successfully.";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        echo 'There was a system error. please contact the technical support';
    } 
} elseif($method == "editIncidentStatus") {
	/*
    * Name: Anass Houlout
    * Desc: Editing incident status
    */
	
	// Get the POST data
    $incidentID = stripcslashes($_POST["incidentId"]);
    $status = stripslashes($_POST["status"]);
    $solution = stripslashes($_POST["solution"]);

	// Employee ID
	$employeeID = $_SESSION['employeeID'];
	
	// Status Date (DateTime Format)
	$status_date = date("Y-m-d H:i:s");
	
	// execute sql query - INCIDENT_STATUS table
    $sql = mysqli_query($DBConnection, "INSERT INTO INCIDENT_STATUS VALUES ('', '$incidentID', '$employeeID', '$status', '$solution', '$status_date')");

	if($sql) 
	{
	    if ($status == 6)
	    {
            $sqlAddDateEnd = "UPDATE INCIDENT SET DateEnd = '$status_date' WHERE IncidentID = $incidentID";
            $endSQL = mysqli_query($DBConnection, $sqlAddDateEnd);
            if ($endSQL)
            {
                $_SESSION['success'] = "Incident updated successfully.";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }


		$_SESSION['success'] = "Incident updated successfully.";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
	} else {
		echo 'There was a system error. please contact the technical support';
	}
} else {
    echo '<p>A problem occured. Please try again.</p>';
}
