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

if (isset($_POST['submit']))
{
    /**
    * Name:	    Jannis Luegering
    * Desc.:	Fill the variables with the form data.
    **/
    $firstName = stripslashes($_POST['firstName']);
    $lastName = stripslashes($_POST['lastName']);
    $email = stripslashes($_POST['email']);
    $password = hash('whirlpool', stripslashes($_POST['password']));
    $authorisation = stripslashes($_POST['authorisation']);
    $pictureURL = 'employeePictures/' . $_FILES['pictureUpload']['name'];

    /**
    * Name:	    Jannis Luegering
    * Desc.:	Insert data for the employee.
    **/
	$tableName = "EMPLOYEE";
	$SQLstring = "INSERT INTO $tableName VALUES(NULL, '$authorisation', '$firstName', '$lastName', '$pictureURL', '$email', '$password')";
	mysqli_query($DBConnect, $SQLstring) OR DIE ("Unable to create employee!");

    /**
    * Name:	    Jannis Luegering
    * Desc.:	Move picture to the right directory to store it.
    **/
    move_uploaded_file($_FILES['pictureUpload']['tmp_name'], 'employeePictures/' . $_FILES['pictureUpload']['name']);
	echo "<p>The employee has been created successfully.</p>";
}
?>

<html>
    <head>
    </head>

    <body>
        <form action="Input_3.php" method="post" enctype="multipart/form-data">

            <label>First Name: </label>
            <input type="text" name="firstName" value="">

            <label>Last Name: </label>
            <input type="text" name="lastName" value="">

            <label>E-Mail: </label>
            <input type="email" name="email" value="">

            <label>Password: </label>
            <input type="text" name="password" value="">

            <label>Authorisation: </label>
            <select name="authorisation">
                <option value="1">Operator</option>
                <option value="2">Team Leader</option>
                <option value="3">Security Operator</option>
            </select>

            <label>Picture: </label>
            <input type="file" name="pictureUpload" id="pictureUpload">

            <input type="submit" name="submit">
        </form>
    </body>
</html>
