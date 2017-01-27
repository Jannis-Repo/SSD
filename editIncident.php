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
				elseif ($_SESSION['auth'] == 0 || $_SESSION['auth'] == 3)
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

				<div class="row wrapper border-bottom white-bg page-heading">

					<?php

						//Set the variables for to be changed incident
						if(isset($_GET['IncidentID']))
						{
							//Set incident ID
							$IncidentID = $_GET['IncidentID'];
							$TableNameIncident = "INCIDENT";
							$TableNameStatus = "INCIDENT_STATUS";
							$TableNameStatusType = "STATUS";
							$SQLstring = "SELECT MAX(`StatusTypeID`), `Description` FROM $TableNameStatus, $TableNameIncident WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameStatus.`IncidentID` = $IncidentID";
							$QueryResult = mysqli_query($DBConnection, $SQLstring);
							$IncidentInfo = mysqli_fetch_assoc($QueryResult);
							//Set incident description
							$IncidentDescription = $IncidentInfo['Description'];
							//Set incident status ID
							$IncidentStatus = $IncidentInfo['MAX(`StatusTypeID`)'];
							$SQLstring = "SELECT `StatusName` FROM $TableNameStatusType WHERE `StatusTypeID` = $IncidentStatus";
							$QueryResult = mysqli_query($DBConnection, $SQLstring);
							$IncidentInfo = mysqli_fetch_assoc($QueryResult);
							//Set incident status name
							$IncidentStatus = $IncidentInfo['StatusName'];
							
							//Get the latest incident status type integer for the change status select dropdown menu
							$sql = "SELECT IncidentID,StatusTypeID,EmployeeID,Date FROM $TableNameStatus WHERE IncidentID = $IncidentID ORDER BY Date DESC";
							$sqlQuery = mysqli_query($DBConnection, $sql);
							$sqlResult = mysqli_fetch_all($sqlQuery, MYSQLI_ASSOC);
							$IncidentStatusTypeID = $sqlResult[0]['StatusTypeID'];
							$IncidentEmployeeID = $sqlResult[0]['EmployeeID'];
							
							//Get Incident priority
							$prioritySql = mysqli_query($DBConnection, "SELECT Priority FROM INCIDENT WHERE IncidentID = $IncidentID");
							$priorityFetch = mysqli_fetch_assoc($prioritySql);
							$IncidentPriority = $priorityFetch['Priority'];
						}

					?>


					<!-- INCIDENT HEADER -->
					<div class="col-lg-10">
						<h2>Incident No. <?php echo $IncidentID; ?></h2>
						<ol class="breadcrumb">
							<li>
								<strong><?php echo $IncidentStatus; ?></strong>
							</li>
							<li>
								<?php echo $IncidentDescription; ?>
							</li>
						</ol>
					</div>
				</div>

				<div class="wrapper wrapper-content">
					<div class="row">
						<!-- ADD STATUS -->
						<div class="col-sm-6">
						<?php
						if($_SESSION['success'])
						{
							echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
							$_SESSION['success'] = "";
						}
						?>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Change status</h5>
								</div>
								<div class="ibox-content">
									<p>Change the status of this incident.</p>
									<form role="form" action="class/formProcessing.php" method="POST">
										<input type="hidden" name="method" value="editIncidentStatus">
										<input type="hidden" name="incidentId" value="<?php echo $IncidentID; ?>">
										<div class="form-group">
											<label>Choose status</label>
											<select class="form-control" name="status">
												<?php

													if($IncidentStatusTypeID == 5)
													{
														echo "<option value=\"6\" selected>Closed</option>";
													}
													if($IncidentStatusTypeID == 4)
													{
														echo "<option value=\"5\" selected>Resolved</option>";
														echo "<option value=\"6\">Closed</option>";
													}
													if($IncidentStatusTypeID == 3)
													{
														echo "<option value=\"4\" selected>Forwarded to Account Manager</option>";
														echo "<option value=\"5\">Resolved</option>";
														echo "<option value=\"6\">Closed</option>";
													}
													if($IncidentStatusTypeID == 2)
													{
														echo "<option value=\"3\" selected>Forwarded to Engineer</option>";
														echo "<option value=\"4\">Forwarded to Account Manager</option>";
														echo "<option value=\"5\">Resolved</option>";
														echo "<option value=\"6\">Closed</option>";
													}
													if($IncidentStatusTypeID == 1)
													{
														echo "<option value=\"2\" selected>Pending</option>";
														echo "<option value=\"3\">Forwarded to Engineer</option>";
														echo "<option value=\"4\">Forwarded to Account Manager</option>";
														echo "<option value=\"5\">Resolved</option>";
														echo "<option value=\"6\">Closed</option>";
													}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Solution</label>
											<input type="text" class="form-control" name="solution">
										</div>
										<div>
											<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Update</strong></button>
											<label></label>
										</div>
									</form>
								</div>
							</div>
						</div>

						<!-- SET PRIORITY -->
						<div class="col-sm-6">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Set priority</h5>
								</div>
								<div class="ibox-content">
									<p>Set a new priority for this incident.</p>
									<form role="form" action="class/formProcessing.php" method="POST">
										<div class="form-group">
											<select class="form-control" name="priority">
												<option value="1" <?php if($IncidentPriority == 1){echo 'selected';} ?>>High</option>
												<option value="2" <?php if($IncidentPriority == 2){echo 'selected';} ?>>Medium</option>
												<option value="3" <?php if($IncidentPriority == 3){echo 'selected';} ?>>Low</option>
											</select>
										</div>
										<input type="hidden" name="method" value="editIncidentPriority">
										<input type="hidden" name="IncidentID" value="<?php echo $IncidentID; ?>">
										<div>
											<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Save</strong></button>
											<label></label>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- ASSIGN INCIDENT -->
						<div class="col-sm-6">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Assign Incident</h5>
																		<?php 
									if($IncidentEmployeeID > 0) 
									{ 
										$SQLstring = "SELECT EmployeeName,EmployeeSurname FROM EMPLOYEE WHERE EmployeeID = $IncidentEmployeeID";
										$Query = mysqli_query($DBConnection, $SQLstring);
										$Result = mysqli_fetch_assoc($Query);
									?>
									<h5 style="float: right"><b>Assigned to:</b> <?= $Result['EmployeeName']." ".$Result['EmployeeSurname'] ?></h5>
									<?php } ?>
								</div>
								<div class="ibox-content">
									<p>Assign this incident to an employee.</p>
									<form role="form" action="class/formProcessing.php" method="POST">
										<div class="form-group">
											<label>Choose employee</label>
											<select class="form-control" name="EmployeeID">
												<?php

													//Selecting all Employees ID's from EMPLOYEE table
													$TableName = "EMPLOYEE";
													$SQLstring = "SELECT * FROM $TableName";
													$QueryResult = mysqli_query($DBConnection, $SQLstring);

													while($Row = mysqli_fetch_assoc($QueryResult))
													{
														if($Row['EmployeeID'] != $IncidentEmployeeID)
														{
														echo "<option value=\"{$Row['EmployeeID']}\">{$Row['EmployeeID']} {$Row['EmployeeName']} {$Row['EmployeeSurname']}</option>";
														}
													}
													mysqli_free_result($QueryResult);

												?>

											</select>
										</div>
										<input type="hidden" name="method" value="assignIncident">
										<input type="hidden" name="IncidentID" value="<?php echo $IncidentID; ?>">
										<input type="hidden" name="currentStatus" value="<?php echo $IncidentStatusTypeID; ?>">
										<div>
											<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Assign</strong></button>
											<label></label>
										</div>
									</form>
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
