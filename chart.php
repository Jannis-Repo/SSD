<?php
//Setup database connection
include 'class/dbConnection.php';

//BarChart
$tableName = "INCIDENT";
$sqlYear = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 365 DAY) and DATE(Now())";
$sqlMonth = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 31 DAY) and DATE(Now())";
$sqlWeek = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 7 DAY) and DATE(Now())";

$resultYear = mysqli_query($DBConnection, $sqlYear) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$yearCount = mysqli_fetch_assoc($resultYear);

$resultMonth = mysqli_query($DBConnection, $sqlMonth) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$monthCount = mysqli_fetch_assoc($resultMonth);

$resultWeek = mysqli_query($DBConnection, $sqlWeek) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$weekCount = mysqli_fetch_assoc($resultWeek);


//DonutChart
$oneDay = 0;
$twoDays = 0;
$ThreeToSixDays = 0;
$TwoToThreeWeeks = 0;

$sqlDonut = "SELECT DateStart, DateEnd FROM INCIDENT WHERE DateEnd!=''";
$resultDonut = mysqli_query($DBConnection, $sqlDonut) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));

//printing the rows
while($row = mysqli_fetch_assoc($resultDonut))
{
	$dateStart = new DateTime($row['DateEnd']);
	$dateEnd = new DateTime($row['DateStart']);

	$diff = $dateStart->diff($dateEnd);
	//REST TOMORROW!

	if (($row['DateEnd'] - $row['DateStart']) <= 86400)
	{
		$oneDay++;
	}
	else if (($row['DateEnd'] - $row['DateStart']) > 86400 && ($row['DateEnd'] - $row['DateStart']) <= (86400 * 2))
	{
		$twoDays++;
	}
	else if (($row['DateEnd'] - $row['DateStart']) > (86400 * 2) && ($row['DateEnd'] - $row['DateStart']) <= (86400 * 6))
	{
		$ThreeToSixDays++;
	}
	else if(($row['DateEnd'] - $row['DateStart']) > (86400 * 6) && ($row['DateEnd'] - $row['DateStart']) <= (86400 * 21))
	{
		$TwoToThreeWeeks++;
	}
}

echo '<br>' . $oneDay;
echo '<br>' . $twoDays;
echo '<br>' . $ThreeToSixDays;
echo '<br>' . $TwoToThreeWeeks;

?>

<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>White Stone Support Desk</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

		<!-- Morris -->
    	<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

		<link href="css/animate.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">

	</head>

	<body>
		<div id="wrapper">

			<!-- COLLAPSABLE SIDE MENU -->
			<?php include "sideNav.php"; ?>

			<div id="page-wrapper" class="gray-bg">
				
				<!-- TOP MENU -->
				<?php include "topNav.php"; ?>

				<div class="wrapper wrapper-content">

					<!-- CHARTS -->
					<div class="row">
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- BAR CHART -->
								<div class="ibox-title">
									<h5>Number of Incidents</h5>
									<div class="ibox-tools">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<div id="morris-bar-chart"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- PIE CHART -->
								<div class="ibox-title">
									<h5>Incident resolution time</h5>
									<div class="ibox-tools">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
											</a>
									</div>
								</div>
								<div class="ibox-content">
									<div id="morris-donut-chart" ></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- FOOTER WITH COPYRIGHT -->
				<?php include "footer.php"; ?>

			</div>
		</div> 

		<!-- SCRIPTS -->
		<?php include "scripts.php"; ?>

		<script language="javascript" type="text/javascript">
			$(function() {
				Morris.Donut({
					element: 'morris-donut-chart',
					data: [{ label: '1 Day', value: 321 },
						{ label: '2 Days', value: 270 },
						{ label: '3 to 6 Days', value: 75 },
						{ label: '2 to 3 Weeks', value: 30 }],
						resize: true,
					colors: ['#87d6c6', '#54cdb4','#1ab394','#1ab33f'],
			});

				Morris.Bar({
					element: 'morris-bar-chart',
					data: [{ y: 'Week', a: <?php echo $weekCount['IncidentCount']; ?>},
						{ y: 'Month', a: <?php echo $monthCount['IncidentCount']; ?>},
						{ y: 'Year', a: <?php echo $yearCount['IncidentCount']; ?>} ],
					xkey: 'y',
					ykeys: ['a'],
					labels: ['Series A'],
					hideHover: 'auto',
					resize: true,
					barColors: ['#1ab394'],
				});
			});
		</script>
		
	</body>

</html>