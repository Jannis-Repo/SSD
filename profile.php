<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>White Stone Support Desk</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet">

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
							'picture' => 'img/user.jpg'
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
						<li class="active">
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
									<li>
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

			<div id="page-wrapper" class="gray-bg" style="display: inline-block;">
				
				<!-- TOP MENU -->
				<?php include "topNav.php"; ?>

				<div class="wrapper wrapper-content">
					<!-- PROFILE DETAILS -->
					<div class="col-md-4">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Profile Details</h5>
							</div>
							<div>
								<div class="ibox-content no-padding border-left-right">
									<img alt="image" class="img-responsive" src="<?php echo $personalData['picture']; ?>">
								</div>
								<div class="ibox-content profile-content">
									<h4>
										<strong><?php echo $personalData['firstName'] . ' ' . $personalData['lastName']; ?></strong><br>
										<small><?php echo $authorisationName[$_SESSION['auth']]; ?></small>
									</h4>
									<p>
										<i class="fa fa-desktop"></i>  <?php echo $personalData['email']; ?>
									</p>
									<div class="row m-t-lg">
										<?php

											$SessionUserID = $_SESSION['employeeID'];
											$AmountOfIncidents = 0;

											if($_SESSION['auth'] == 0)
											{

												//Select incident records to display
												$TableNameIncident = "INCIDENT";
												$TableNameStatus = "INCIDENT_STATUS";
												$TableNameStatusType = "STATUS";
												$TableNameIncidentType = "INCIDENT_TYPE";
												$TableNameEmployee = "EMPLOYEE";
												$SQLstringOne = "SELECT $TableNameIncident.`IncidentID`, MAX(`StatusTypeID`), `UserID` FROM $TableNameStatus, $TableNameIncident WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` GROUP BY $TableNameIncident.`IncidentID` ORDER BY `Priority` DESC, $TableNameStatus.`IncidentID`";
												$QueryResult = mysqli_query($DBConnection, $SQLstringOne);

												while ($TableRow = mysqli_fetch_assoc($QueryResult))
												{
													if ($TableRow['UserID'] == $SessionUserID)
													{
														$AmountOfIncidents += 1;
													}
												}

												echo "<div class=\"col-md-6\">
														<span class=\"label label-primary\">" . $AmountOfIncidents . "</span>
														<h5>Submitted incidents</h5>
													</div>";
											}
											elseif($_SESSION['auth'] == 1 || $_SESSION['auth'] == 2 || $_SESSION['auth'] == 4)
											{

												//Select incident records to display
												$TableNameIncident = "INCIDENT";
												$TableNameStatus = "INCIDENT_STATUS";
												$TableNameStatusType = "STATUS";
												$TableNameIncidentType = "INCIDENT_TYPE";
												$SQLstringOne = "SELECT $TableNameStatus.`IncidentID`, MAX(`StatusTypeID`) FROM $TableNameStatus, $TableNameIncident WHERE $TableNameStatus.`IncidentID` = $TableNameIncident.`IncidentID` GROUP BY `IncidentID` ORDER BY `Priority` DESC, $TableNameStatus.`IncidentID`";
												$QueryResult = mysqli_query($DBConnection, $SQLstringOne);

												//Display results in a table format
												while ($TableRow = mysqli_fetch_assoc($QueryResult))
												{
													if ($TableRow['MAX(`StatusTypeID`)'] != 6)
													{
														$IncidentID = $TableRow['IncidentID'];
														$StatusID = $TableRow['MAX(`StatusTypeID`)'];
														$SQLstringTwo = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `StatusName`, `Date` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID AND $TableNameStatus.`EmployeeID` = $SessionUserID";
														$QueryResultRow = mysqli_query($DBConnection, $SQLstringTwo);

														while ($IncidentRow = mysqli_fetch_assoc($QueryResultRow))
														{
															$AmountOfIncidents += 1;
														}
													}
												}

												echo "<div class=\"col-md-6\">
														<span class=\"label label-primary\">" . $AmountOfIncidents . "</span>
														<h5>Incidents in progress</h5>
													</div>";

												$SolvedIncidents = 0;
												//Select incident records to display
												$SQLstringThree = "SELECT COUNT(`Solution`) FROM $TableNameStatus WHERE $TableNameStatus.`EmployeeID` = " . $SessionUserID;
												$QuerySolvedResult = mysqli_query($DBConnection, $SQLstringThree);
												$SolvedIncidents = mysqli_fetch_assoc($QuerySolvedResult);

												echo "<div class=\"col-md-6\">
														<span class=\"label label-primary\">" . $SolvedIncidents['COUNT(`Solution`)'] . "</span>
														<h5>Solved incidents</h5>
													</div>";

											}	

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- INCIDENT TABLE -->
					<div class="col-md-8">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Current Incidents</h5>
							</div>
							<!-- TABLE DATA -->
							<div class="ibox-content">
								<div class="table-responsive">
									<table class="table table-striped">
										
										<?php

											//User table
											if($_SESSION['auth'] == 0){

												echo "<thead>
														<tr>
															<th>IncidentID</th>
															<th>Description</th>
															<th>Solution</th>
															<th>Type</th>
															<th>Status</th>
															<th>Date</th>
															<th>Employee</th>
														</tr>
													</thead>
													<tbody>";

												$QueryResult = mysqli_query($DBConnection, $SQLstringOne);
												//Display results in a table format
												while ($TableRow = mysqli_fetch_assoc($QueryResult))
												{
													if ($TableRow['UserID'] == $SessionUserID)
													{	
														$IncidentID = $TableRow['IncidentID'];
														$StatusID = $TableRow['MAX(`StatusTypeID`)'];
														$SQLstringTwo = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `StatusName`, `Date`, `Picture` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType, $TableNameEmployee WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`EmployeeID` = $TableNameEmployee.`EmployeeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID";
														$QueryResultRow = mysqli_query($DBConnection, $SQLstringTwo);
														if (mysqli_num_rows($QueryResultRow) == 0)
														{
															$SQLstringTwo = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `StatusName`, `Date` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID";
															$QueryResultRow = mysqli_query($DBConnection, $SQLstringTwo);
															$IncidentRow = mysqli_fetch_assoc($QueryResultRow);
															echo "<tr>";
															echo "<td>{$IncidentRow['IncidentID']}</td>";
															echo "<td>{$IncidentRow['Description']}</td>";
															echo "<td>{$IncidentRow['Solution']}</td>";
															echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
															echo "<td>{$IncidentRow['StatusName']}</td>";
															echo "<td>{$IncidentRow['Date']}</td>";
															echo "<td></td>";
															echo "</tr>";

														}
														else
														{
															while ($IncidentRow = mysqli_fetch_assoc($QueryResultRow)){
																echo "<tr>";
																echo "<td>{$IncidentRow['IncidentID']}</td>";
																echo "<td>{$IncidentRow['Description']}</td>";
																echo "<td>{$IncidentRow['Solution']}</td>";
																echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
																echo "<td>{$IncidentRow['StatusName']}</td>";
																echo "<td>{$IncidentRow['Date']}</td>";
																echo "<td><img alt=\"image\" class=\"img-circle\" src=\"" . $IncidentRow['Picture'] . "\" /></td>";
																echo "</tr>";
															}
														}
													}
												}
												mysqli_free_result($QueryResult);
												mysqli_free_result($QueryResultRow);

											}
											//Employee table
											elseif($_SESSION['auth'] == 1 || $_SESSION['auth'] == 2 || $_SESSION['auth'] == 4)
											{

												echo "<thead>
														<tr>
															<th>IncidentID</th>
															<th>Description</th>
															<th>Solution</th>
															<th>Type</th>
															<th>Status</th>
															<th>Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>";

												$QueryResult = mysqli_query($DBConnection, $SQLstringOne);
												//Display results in a table format
												while ($TableRow = mysqli_fetch_assoc($QueryResult))
												{
													if ($TableRow['MAX(`StatusTypeID`)'] != 6)
													{
														$IncidentID = $TableRow['IncidentID'];
														$StatusID = $TableRow['MAX(`StatusTypeID`)'];
														$SQLstringTwo = "SELECT $TableNameIncident.`IncidentID`, `DateStart`, `Description`, `Solution`, `IncidentTypeName`, `StatusName`, `Date` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID AND $TableNameStatus.`EmployeeID` = $SessionUserID";
														$QueryResultRow = mysqli_query($DBConnection, $SQLstringTwo);

														while ($IncidentRow = mysqli_fetch_assoc($QueryResultRow)){
															echo "<tr>";
															echo "<td>{$IncidentRow['IncidentID']}";
																date_default_timezone_set("Europe/Amsterdam");
																$today = date("Y-m-d H:i:s");
																$time = $IncidentRow['DateStart'];
																if (strtotime($time) < (strtotime($today) - 604800))
																{
																	echo "&emsp;<i class=\"fa fa-warning\" style=\"color:red\"></i>";
																}
																elseif (strtotime($time) < (strtotime($today) - 259200))
																{
																	echo "&emsp;<i class=\"fa fa-warning\" style=\"color:yellow\"></i>";
																}
															echo "</td>";
															echo "<td>{$IncidentRow['Description']}</td>";
															echo "<td>{$IncidentRow['Solution']}</td>";
															echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
															echo "<td>{$IncidentRow['StatusName']}</td>";
															echo "<td>{$IncidentRow['Date']}</td>";
															echo "<td><a href=\"editIncident.php?IncidentID={$IncidentRow['IncidentID']}\"><i class=\"fa fa-edit\"></i></a></td>";
															echo "</tr>";
														}
													}
												}
												mysqli_free_result($QueryResult);
												mysqli_free_result($QueryResultRow);

											}
											elseif($_SESSION['auth'] == 3)
											{
												echo "<tr><td colspan=\"7\"> Not applicable.</td></tr>";
											}

										?>

										</tbody>
									</table>
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

	</body>

</html>