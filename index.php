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

			<div id="page-wrapper" class="gray-bg">
				
				<!-- TOP MENU -->
				<?php include "topNav.php"; ?>

				<!-- SEARCH FOR USERS -->
				<?php

					if($_SESSION['auth'] == 0)
					{
						echo "<div class=\"row wrapper border-bottom white-bg page-heading\">

								<div class=\"col-lg-9 search-bar-top-padding\">
								
								
								<form method=\"GET\" class=\"form-horizontal\" action=\"index.php\">
                                	<div class=\"input-group\">
                                		<input type=\"text\" name=\"searchText\" placeholder=\"Search\" class=\"input-sm form-control\">
                                		<span class=\"input-group-btn\">
                                			<button class=\"btn btn-primary search-bar-button\" type=\"submit\"> Search!</button>
                                    	</span>
                                    </div>
                                </form>
								</div>
							</div>";
					}

				?>

				<div class="wrapper wrapper-content">
					<!-- INCIDENTS TABLE -->
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox float-e-margins">
								<!-- TABLE DESCRIPTION AND FUNCTION -->
								<div class="ibox-title">
									<?php
										$SessionUserID = $_SESSION['employeeID'];

										if($_SESSION['auth'] == 0)
										{
											$TableNameUser = "USER";
											$TableNameClient = "CLIENT";
											$SQLstring = "SELECT `ClientName` FROM $TableNameUser, $TableNameClient WHERE $TableNameUser.`ClientID` = $TableNameClient.`ClientID` AND $TableNameUser.`UserID` = " . $SessionUserID;
											$QueryResult = mysqli_query($DBConnection, $SQLstring);
											$ClientName = mysqli_fetch_assoc($QueryResult);
											echo "<h5>Incidents of " . $ClientName['ClientName'] . "</h5>";
										}
										else
										{
											echo "<h5>Incidents in progress</h5>";
										}
									?>
								</div>
								<!-- TABLE DATA -->
								<div class="ibox-content">
									<div class="table-responsive">
										<table class="table table-striped">

											<?php 

												//User table
												if($_SESSION['auth'] == 0)
												{
													echo "<thead>
															<tr>
																<th>IncidentID</th>
																<th>Description</th>
																<th>Solution</th>
																<th>Type</th>
																<th>Status</th>
																<th>Priority</th>
																<th>Date</th>
																<th>Employee</th>
															</tr>
														</thead>
														<tbody>";

													//Select incident records to display
													$TableNameIncident = "INCIDENT";
													$TableNameStatus = "INCIDENT_STATUS";
													$TableNameStatusType = "STATUS";
													$TableNameIncidentType = "INCIDENT_TYPE";
													$TableNameEmployee = "EMPLOYEE";
													$TableNameUser = "USER";
													$SQLstring = "SELECT `ClientID` FROM $TableNameUser WHERE `UserID` = " . $SessionUserID;
													$QueryResult = mysqli_query($DBConnection, $SQLstring);
													$ClientID = mysqli_fetch_assoc($QueryResult);
													mysqli_free_result($QueryResult);


                                                    if (isset($_GET['searchText']))
                                                    {
                                                        $searchString = $_GET['searchText'];
                                                        $searchString = 'AND INCIDENT.`Description` LIKE \'%' . $searchString . '%\'';
                                                    }
                                                    else
                                                    {
                                                        $searchString = '';
                                                    }

													$SQLstring = "SELECT $TableNameIncident.`IncidentID`, MAX(`StatusTypeID`), $TableNameIncident.`UserID`, `ClientID` FROM $TableNameStatus, $TableNameIncident, $TableNameUser WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameUser.`UserID` = $TableNameIncident.`UserID` $searchString GROUP BY $TableNameIncident.`IncidentID` ORDER BY `Priority` DESC, $TableNameStatus.`IncidentID`";

													$QueryResult = mysqli_query($DBConnection, $SQLstring);

													//Display results in a table format
													while ($TableRow = mysqli_fetch_assoc($QueryResult))
													{
														if($TableRow['ClientID'] == $ClientID['ClientID'])
														{
															$IncidentID = $TableRow['IncidentID'];
															$StatusID = $TableRow['MAX(`StatusTypeID`)'];
															$SQLstring = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `Priority`, `StatusName`, `Date`, `Picture` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType, $TableNameUser, $TableNameEmployee WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameUser.`UserID` = $TableNameIncident.`UserID` AND $TableNameStatus.`EmployeeID` = $TableNameEmployee.`EmployeeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID";
															$QueryResultRow = mysqli_query($DBConnection, $SQLstring);
															if (mysqli_num_rows($QueryResultRow) == 0)
															{
																$SQLstring = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `Priority`, `StatusName`, `Date` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType, $TableNameUser WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID";
																$QueryResultRow = mysqli_query($DBConnection, $SQLstring);
																$IncidentRow = mysqli_fetch_assoc($QueryResultRow);
																echo "<tr>";
																echo "<td>{$IncidentRow['IncidentID']}</td>";
																echo "<td>{$IncidentRow['Description']}</td>";
																echo "<td>{$IncidentRow['Solution']}</td>";
																echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
																echo "<td>{$IncidentRow['StatusName']}</td>";
																echo "<td>{$IncidentRow['Priority']}</td>";
																echo "<td>{$IncidentRow['Date']}</td>";
																echo "<td></td>";
																echo "</tr>";
															}
															else
															{
																$IncidentRow = mysqli_fetch_assoc($QueryResultRow);
																echo "<tr>";
																echo "<td>{$IncidentRow['IncidentID']}</td>";
																echo "<td>{$IncidentRow['Description']}</td>";
																echo "<td>{$IncidentRow['Solution']}</td>";
																echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
																echo "<td>{$IncidentRow['StatusName']}</td>";
																echo "<td>{$IncidentRow['Priority']}</td>";
																echo "<td>{$IncidentRow['Date']}</td>";
																echo "<td><img alt=\"image\" class=\"img-circle\" src=\"" . $IncidentRow['Picture'] . "\" /></td>";
																echo "</tr>";
															}
														}
													}
													mysqli_free_result($QueryResult);
													mysqli_free_result($QueryResultRow);

												}
												else
												{
													echo "<thead>
															<tr>
																<th>IncidentID</th>
																<th>Description</th>
																<th>Solution</th>
																<th>Type</th>
																<th>Status</th>
																<th>Priority</th>
																<th>Date</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>";

													//Select incident records to display
													$TableNameIncident = "INCIDENT";
													$TableNameStatus = "INCIDENT_STATUS";
													$TableNameStatusType = "STATUS";
													$TableNameIncidentType = "INCIDENT_TYPE";
													$SQLstring = "SELECT $TableNameStatus.`IncidentID`, MAX(`StatusTypeID`) FROM $TableNameStatus, $TableNameIncident WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` GROUP BY `IncidentID` ORDER BY `Priority` DESC, $TableNameStatus.`IncidentID`";
													$QueryResult = mysqli_query($DBConnection, $SQLstring);

													//Display results in a table format
													while ($TableRow = mysqli_fetch_assoc($QueryResult))
													{
														if ($TableRow['MAX(`StatusTypeID`)'] != 1 && $TableRow['MAX(`StatusTypeID`)'] != 6)
														{
															$IncidentID = $TableRow['IncidentID'];
															$StatusID = $TableRow['MAX(`StatusTypeID`)'];
															$SQLstring = "SELECT $TableNameIncident.`IncidentID`, `DateStart`, `Description`, `Solution`, `IncidentTypeName`, `Priority`, `StatusName`, `Date` FROM $TableNameIncident, $TableNameStatus, `$TableNameStatusType`, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` AND $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` AND $TableNameStatus.`StatusTypeID` = $StatusID AND $TableNameStatus.`IncidentID` = $IncidentID";
															$QueryResultRow = mysqli_query($DBConnection, $SQLstring);

															while ($IncidentRow = mysqli_fetch_assoc($QueryResultRow))
															{
																echo "<tr>";
																echo "<td>{$IncidentRow['IncidentID']}";
																	date_default_timezone_set("Europe/Amsterdam");
																	$today = date("Y-m-d H:i:s");
																	$time = $IncidentRow['DateStart'];
																	if (strtotime($time) < (strtotime($today) - 604800))
																	{
																		echo "&emsp;<i class=\"fa fa-warning\" style=\"color:red\">";
																	}
																	elseif (strtotime($time) < (strtotime($today) - 259200))
																	{
																		echo "&emsp;<i class=\"fa fa-warning\" style=\"color:yellow\">";
																	}
																echo "</td>";
																echo "<td>{$IncidentRow['Description']}</td>";
																echo "<td>{$IncidentRow['Solution']}</td>";
																echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
																echo "<td>{$IncidentRow['StatusName']}</td>";
																echo "<td>{$IncidentRow['Priority']}</td>";
																echo "<td>{$IncidentRow['Date']}</td>";
																echo "<td><a href=\"editIncident.php?IncidentID={$IncidentRow['IncidentID']}\"><i class=\"fa fa-edit\"></i></a></td>";
																echo "</tr>";
															}
														}
													}
													mysqli_free_result($QueryResult);
													mysqli_free_result($QueryResultRow);
												}

											?>

											</tbody>
										</table>
									</div>
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