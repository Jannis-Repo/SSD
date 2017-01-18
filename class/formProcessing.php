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
    echo '<pre>';
    var_dump($result);
    var_dump($SQLstring);
    echo '</pre>';
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
            $_SESSION['loggedIn'] = true;
            $_SESSION['employeeID'] = $row['UserID'];
            $_SESSION['auth'] = 0;
            mysqli_free_result($result);
            header('Location: http://www.stenden.protonbytez.com/');
            exit;
        }
        else
        {
            echo '<p>E-Mail or Password wrong.</p>';
            echo '<p>Please try again.</p>';
        }
    }
}
else
{
    echo '<p>A problem occured. Please try again.</p>';
}
