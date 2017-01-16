<?php 
/* 
* Anass Houlout
* Input 5 - Creating Client
*/

// Require config file to establish database connection
require('');

// Check if form has been submitted
if(isset($_POST["create"]))
{
	// Prepare post data 
	$ClientName = mysqli_real_escape_string($DBConnect, $_POST["ClientName"]);
	$ClientAddress = mysqli_real_escape_string($DBConnect, $_POST["ClientAddress"]);
	$ClientEmail = mysqli_real_escape_string($DBConnect, $_POST["ClientEmail"]);
	$ClientType = mysqli_real_escape_string($DBConnect, $_POST["ClientType"]);

	// Prepare sql query and execute
	$sql2 = "INSERT INTO CLIENT VALUES ('', '$ClientName', '$ClientAddress', '$ClientEmail', '$ClientType')";
	if(mysqli_query($DBConnect, $sql2)) {
		echo "Client has been added successfully!";
	} else {
		die('Fatal error: '. mysqli_error($DBConnect));
	}
}

// Client types records to be used on a select dropdown menu
$sql = "SELECT * FROM CLIENT_TYPE ORDER BY ClientTypeName";
$result = mysqli_query($DBConnect, $sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>White Stone Backend - Create Client</title>
</head>
<body>
	<form action="" method="POST">
		<h3>Create Client</h3>
		Client name: <input type="text" name="ClientName"> <br>
		Client Address: <input type="text" name="ClientAddress"> <br>
		Client Email: <input type="text" name="ClientEmail"> <br>
		Client Type:
		<select name="ClientType">
		<?php 
			if (mysqli_num_rows($result) > 0) {
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "<option value=".$row['ClientTypeID'].">".$row['ClientTypeName']."</option>";
			    }
			} else {
			    echo "<option>No client type data</option>";
			}
		?> 
		</select> <br>
		<input type="submit" name="create" value="Create client">
	</form>
	<?php mysqli_close($DBConnect); ?>
</body>
</html>
