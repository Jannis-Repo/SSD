<?php

session_start();

if ($_SESSION['loggedIn'] != true)
{
	header('Location: http://www.stenden.protonbytez.com/login.php');
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

	$sideNavtableName = "EMPLOYEE";
	$sideNavsqlString = "SELECT EmployeeID, EmployeeEmail, EmployeeName, EmployeeSurname, PICTURE FROM $sideNavtableName WHERE EmployeeID=" . $_SESSION['employeeID'];
	$sideNavResult = mysqli_query($DBConnection, $sideNavsqlString) OR DIE ('Error: ' . mysqli_errno($DBConnection) . mysqli_error($DBConnection));
	$sideNavRow = mysqli_fetch_assoc($sideNavResult);
	mysqli_free_result($sideNavResult);
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
						<a href="profile.php"><img alt="image" class="img-circle" src="<?php echo $sideNavRow['PICTURE']; ?>" /></a>
					</span>
					<a href="profile.php">
						<span class="clear">
							<span class="block m-t-xs"><strong class="font-bold"><?php echo utf8_decode($sideNavRow['EmployeeName']) . ' ' . utf8_decode($sideNavRow['EmployeeSurname']); ?></strong></span>
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
			<li class="active">
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

			<!-- GRAPHS LINK -->
			<li>
				<a href="chart.php"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Charts</span> </a>
			</li>

			<!-- ADD INCIDENT LINK -->
			<li>
				<a href="addIncident.php"><i class="fa fa-edit"></i> <span class="nav-label">Add Incident</span> </a>
			</li>

			<!-- ALL INCIDENTS LINK -->
			<li>
				<a href="allIncidents.php"><i class="fa fa-database"></i> <span class="nav-label">All Incidents</span> </a>
			</li>

			<!-- ADD USERS DROP DOWN LIST -->
			<li>
				<a href="#"><i class="fa fa-sitemap"></i></i> <span class="nav-label">Add User</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="addUser.php">User</a></li>
					<li><a href="addClient.php">Client</a></li>
					<li><a href="addEmployee.php">Employee</a></li>
				</ul>
			</li>

		</ul>
	</div>
</nav>

<!-- SAMPLE PICS

	<i class="fa fa-diamond"></i>
	<i class="fa fa-envelope"></i>
	<i class="fa fa-edit"></i>
	<i class="fa fa-desktop"></i>
	<i class="fa fa-files-o"></i>
	<i class="fa fa-globe"></i>
	<i class="fa fa-flask"></i>
	<i class="fa fa-laptop"></i>
	<i class="fa fa-picture-o"></i>
	<i class="fa fa-sitemap"></i>
	<i class="fa fa-magic"></i>
	<i class="fa fa-star"></i>
	<i class="fa fa-database"></i>

-->			