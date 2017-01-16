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
    $email = stripslashes($_POST['email']);
    $password = hash('whirlpool', stripslashes($_POST['password']));

    /**
    * Name:	    Jannis Luegering
    * Desc.:	Get the employee password that is stored in the database.
    **/
	$tableName = "EMPLOYEE";
	$SQLstring = "SELECT EmployeeID, EmployeePassword FROM $tableName WHERE EmployeeEmail = '$email'";
	$result = mysqli_query($DBConnect, $SQLstring);

    /**
    * Name:	    Jannis Luegering
    * Desc.:	Check if the password matches with the database.
    **/
    while($row = mysqli_fetch_assoc($result))
    {
        if ($row['EmployeePassword'] == $password)
        {
            $_SESSION['loggedIn'] = true;
            $_SESSION['employeeID'] = $row['EmployeeID'];
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
?>

<html>
    <head>
    </head>

    <body>
        <form action="log_in.php" method="post">

            <label>E-Mail: </label>
            <input type="email" name="email" value="">

            <label>Password: </label>
            <input type="password" name="password" value="">

            <input type="submit" name="submit">
        </form>
    </body>
</html>
