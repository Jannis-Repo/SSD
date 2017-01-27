<?php
//Setup database connection
include 'class/dbConnection.php';

//BarChart NumberOfIncidents
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



//BarChart NumberOfResolvedIncidents
$tableResolvedName = "INCIDENT";
$sqlResolvedYear = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd != '' AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 365 DAY) and DATE(Now())";
$sqlResolvedMonth = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd != '' AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 31 DAY) and DATE(Now())";
$sqlResolvedWeek = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd != '' AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 7 DAY) and DATE(Now())";

$resultResolvedYear = mysqli_query($DBConnection, $sqlResolvedYear) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$yearResolvedCount = mysqli_fetch_assoc($resultResolvedYear);

$resultResolvedMonth = mysqli_query($DBConnection, $sqlResolvedMonth) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$monthResolvedCount = mysqli_fetch_assoc($resultResolvedMonth);

$resultResolvedWeek = mysqli_query($DBConnection, $sqlResolvedWeek) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$weekResolvedCount = mysqli_fetch_assoc($resultResolvedWeek);



//BarChart NumberOfOpenIncidents
/*
$sqlYearOpen = "SELECT Count(IncidentID) AS IncidentCount FROM INCIDENT_STATUS t1 WHERE NOT EXISTS (SELECT * FROM INCIDENT_STATUS t2 WHERE t1.IncidentID = t2.IncidentID AND t1.StatusTypeID <> t2.StatusTypeID) AND t1.StatusTypeID NOT IN (2,3,4,5,6) AND t1.Date BETWEEN DATE_SUB(DATE(Now()), INTERVAL 365 DAY) and DATE(Now())";
$sqlMonthOpen = "SELECT Count(IncidentID) AS IncidentCount FROM INCIDENT_STATUS t1 WHERE NOT EXISTS (SELECT * FROM INCIDENT_STATUS t2 WHERE t1.IncidentID = t2.IncidentID AND t1.StatusTypeID <> t2.StatusTypeID) AND t1.StatusTypeID NOT IN (2,3,4,5,6) AND t1.Date BETWEEN DATE_SUB(DATE(Now()), INTERVAL 31 DAY) and DATE(Now())";
$sqlWeekOpen = "SELECT Count(IncidentID) AS IncidentCount FROM INCIDENT_STATUS t1 WHERE NOT EXISTS (SELECT * FROM INCIDENT_STATUS t2 WHERE t1.IncidentID = t2.IncidentID AND t1.StatusTypeID <> t2.StatusTypeID) AND t1.StatusTypeID NOT IN (2,3,4,5,6) AND t1.Date BETWEEN DATE_SUB(DATE(NOW()) , INTERVAL 7 DAY) AND DATE(NOW())";
*/
$sqlYearOpen = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd is null AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 365 DAY) and DATE(Now())";
$sqlMonthOpen = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd is null AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 31 DAY) and DATE(Now())";
$sqlWeekOpen = "SELECT COUNT(IncidentID) AS IncidentCount FROM INCIDENT WHERE DateEnd is null AND DateStart BETWEEN DATE_SUB(DATE(Now()), INTERVAL 7 DAY) and DATE(Now())";

$resultYearOpen = mysqli_query($DBConnection, $sqlYearOpen) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$yearCountOpen = mysqli_fetch_assoc($resultYearOpen);

$resultMonthOpen = mysqli_query($DBConnection, $sqlMonthOpen) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$monthCountOpen = mysqli_fetch_assoc($resultMonthOpen);

$resultWeekOpen = mysqli_query($DBConnection, $sqlWeekOpen) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
$weekCountOpen = mysqli_fetch_assoc($resultWeekOpen);



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
	$timeDiff = strtotime($row['DateEnd']) - strtotime($row['DateStart']);

	if ($timeDiff <= 86400)
	{
		$oneDay++;
	}
	else if ($timeDiff > 86400 && $timeDiff <= (86400 * 2))
	{
		$twoDays++;
	}
	else if ($timeDiff > (86400 * 2) && $timeDiff <= (86400 * 6))
	{
		$ThreeToSixDays++;
	}
	else if($timeDiff > (86400 * 6) && $timeDiff <= (86400 * 21))
	{
		$TwoToThreeWeeks++;
	}
}

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
			<?php

				session_start();

				if ($_SESSION['loggedIn'] != true)
				{
					header('Location: http://www.stenden.protonbytez.com/login.php');
					exit;
				}
				elseif ($_SESSION['auth'] != 2 && $_SESSION['auth'] != 4)
				{
					header('Location: http://www.stenden.protonbytez.com/index.php');
					exit;
				}
				else
				{
					include 'class/dbConnection.php';

					$authorisationName = array(
						'User',
						'Operator',
						'Team Leader',
						'Security Operator',
						'Master'
					);

					if ($_SESSION['auth'] == 0)
					{
						$tableName = "USER";
						$columnNames = "UserID, UserEmail, UserName, UserSurname";
						$whereClause = "UserID";
					}
					else
					{
						$tableName = "EMPLOYEE";
						$columnNames = "EmployeeID, EmployeeEmail, EmployeeName, EmployeeSurname, Picture";
						$whereClause = "EmployeeID";
					}


					$sqlString = "SELECT $columnNames FROM $tableName WHERE $whereClause =" . $_SESSION['employeeID'];
					$result = mysqli_query($DBConnection, $sqlString) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
					$row = mysqli_fetch_assoc($result);
					mysqli_free_result($result);

					$personalData = array();

					if ($_SESSION['auth'] == 0)
					{
						$personalData = array (
							'firstName' => $row['UserName'],
							'lastName' => $row['UserSurname'],
							'email' => $row['UserEmail'],
							'picture' => 'img/user.jpg'	//need to fill in a basic picture for an user!
						);
					}
					else
					{
						$personalData = array (
							'firstName' => $row['EmployeeName'],
							'lastName' => $row['EmployeeSurname'],
							'email' => $row['EmployeeEmail'],
							'picture' => $row['Picture']
						);
					}
				}
			?>

			<!-- COLLAPSABLE SIDE MENU -->
			<nav class="navbar-default navbar-static-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav" id="side-menu">
					
						<!-- NAV BAR TOP -->
						<li class="nav-header">
							<!-- PROFILE INFORMATION -->
							<div class="dropdown profile-element">
								<span>
									<a href="profile.php"><img alt="image" class="img-circle" src="<?php echo $personalData['picture']; ?>" /></a>
								</span>
								<a href="profile.php">
									<span class="clear">
										<span class="block m-t-xs"><strong class="font-bold"><?php echo $personalData['firstName'] . ' ' . $personalData['lastName']; ?></strong></span>
										<span class="text-muted text-xs block"><?php echo $authorisationName[$_SESSION['auth']]; ?></span>
									</span>
								</a>
							</div>
							<!-- CLOSED NAV BAR LOGO ELEMENT -->
							<div class="logo-element">
								<a href="profile.php">WS</a>
							</div>
						</li>

						<!-- DASHBOARD -->
						<li>
							<a href="index.php"><i class="fa fa-th-large"></i><span class="nav-label">Dashboard</span></a>
						</li>

						<!-- PROFILE DROP DOWN LIST -->
						<li>
							<a href="#"><i class="fa fa-picture-o"></i></i> <span class="nav-label">Profile</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="http://outlook.live.com" target="_blank">Mailbox</a></li>
								<li class="divider"></li>
								<li><a href="login.php">Log out</a></li>
							</ul>
						</li>

						<?php

							if($_SESSION['auth'] == 2 || $_SESSION['auth'] == 4)
							{
								echo "<!-- GRAPHS LINK -->
									<li class=\"active\">
										<a href=\"chart.php\"><i class=\"fa fa-bar-chart-o\"></i> <span class=\"nav-label\">Charts</span> </a>
									</li>";
							}

							if($_SESSION['auth'] != 3)
							{
								echo "<!-- ADD INCIDENT LINK -->
									<li>
										<a href=\"addIncident.php\"><i class=\"fa fa-edit\"></i> <span class=\"nav-label\">Add Incident</span> </a>
									</li>";
							}

							if($_SESSION['auth'] == 1 || $_SESSION['auth'] == 2 || $_SESSION['auth'] == 4)
							{
								echo "<!-- ALL INCIDENTS LINK -->
									<li>
										<a href=\"allIncidents.php\"><i class=\"fa fa-database\"></i> <span class=\"nav-label\">All Incidents</span> </a>
									</li>";
							}

							if($_SESSION['auth'] > 2)
							{
								echo "<!-- ADD USERS DROP DOWN LIST -->
									<li>
										<a href=\"#\"><i class=\"fa fa-sitemap\"></i></i> <span class=\"nav-label\">Add User</span><span class=\"fa arrow\"></span></a>
										<ul class=\"nav nav-second-level\">
											<li><a href=\"addUser.php\">User</a></li>
											<li><a href=\"addClient.php\">Client</a></li>
											<li><a href=\"addEmployee.php\">Employee</a></li>
										</ul>
									</li>";
							}
							
						?>

					</ul>
				</div>
			</nav>

			<div id="page-wrapper" class="gray-bg">
				
				<!-- TOP MENU -->
				<?php include "topNav.php"; ?>

				<div class="wrapper wrapper-content">

					<!-- CHARTS -->
					<div class="row">
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- PIE CHART -->
								<div class="ibox-title">
									<h5>Incident resolution time</h5>
								</div>
								<div class="ibox-content">
									<div id="morris-donut-chart" ></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- BAR CHART -->
								<div class="ibox-title">
									<h5>Number of Incidents</h5>
								</div>
								<div class="ibox-content">
									<div id="morris-bar-chart-1"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- BAR CHART -->
								<div class="ibox-title">
									<h5>Number of resolved Incidents</h5>
								</div>
								<div class="ibox-content">
									<div id="morris-bar-chart-2"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="ibox float-e-margins">

								<!-- BAR CHART -->
								<div class="ibox-title">
									<h5>Number of open Incidents</h5>
								</div>
								<div class="ibox-content">
									<div id="morris-bar-chart-3"></div>
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
					data: [{ label: '1 Day', value: <?php echo $oneDay; ?> },
						{ label: '2 Days', value: <?php echo $twoDays; ?> },
						{ label: '3 to 6 Days', value: <?php echo $ThreeToSixDays; ?> },
						{ label: '2 to 3 Weeks', value: <?php echo $TwoToThreeWeeks; ?> }],
						resize: true,
					colors: ['#87d6c6', '#54cdb4','#1ab394','#1ab33f'],
				});

				Morris.Bar({
					element: 'morris-bar-chart-1',
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

				Morris.Bar({
					element: 'morris-bar-chart-2',
					data: [{ y: 'Week', a: <?php echo $weekResolvedCount['IncidentCount']; ?>},
						{ y: 'Month', a: <?php echo $monthResolvedCount['IncidentCount']; ?>},
						{ y: 'Year', a: <?php echo $yearResolvedCount['IncidentCount']; ?>} ],
					xkey: 'y',
					ykeys: ['a'],
					labels: ['Series A'],
					hideHover: 'auto',
					resize: true,
					barColors: ['#1ab394'],
				});

				Morris.Bar({
					element: 'morris-bar-chart-3',
					data: [{ y: 'Week', a: <?php echo $weekCountOpen['IncidentCount']; ?>},
						{ y: 'Month', a: <?php echo $monthCountOpen['IncidentCount']; ?>},
						{ y: 'Year', a: <?php echo $yearCountOpen['IncidentCount']; ?>} ],
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