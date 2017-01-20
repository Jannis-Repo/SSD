<?php
	/* Sona Gautam
	Output 2 - Resolution time */
	
	$ResoultionTime = mysqli_connect($DBConnect, $_GET['ResolutionTime']);

	// SQL
	$sql = "SELECT DateStart, DateEnd FROM IncidentID WHERE DateEnd!=''";
	//Excecuting multi query
	
	//fetch the data
		$result = mysql_query($sql);
		if(!$result) 
		{
			$message = 'Invalid query: ' . mysql_error() . "n";
			$message = 'Whole query: ' . $query;
			die ($message);
		}

		$oneDay = 0;
		$twoDays = 0;
		$ThreeToSixDays = 0;
		$TwoToThreeWeeks = 0;

		//printing the rows
		while($row = mysql_fetch_assoc($result))
		{
			if ($row['DateEnd'] - $row['DateStart'] <= 86400)
			{
				$oneDay = $oneDay + 1;
			}
			else if ($row['DateEnd'] - $row['DateStart'] > 86400 && $row['DateEnd'] - $row['DateStart'] <= 86400 * 2)
			{
				$twoDays = $twoDays + 1;
			}
			else ($row['DateEnd'] - $row['DateStart'] > 86400 * 2 && $row['DateEnd'] - $row['DateStart'] <= 86400 * 6)
			{
				$ThreeToSixDays = $ThreeToSixDays + 1;
			} 
			if ($row['DateEnd'] - $row['DateStart'] > 86400 * 6 && $row['DateEnd'] - $row['DateStart'] <= 86400 * 21)
			{
				$TwoToThreeWeeks = $TwoToThreeWeeks + 1;
			}
			
		//close the connection
		mysql_close($link);

	
?>


