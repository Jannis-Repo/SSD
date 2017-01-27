<?php
require("class/dbConnection.php");
$SQLstring = "SELECT * FROM CLIENT";
$query = mysqli_query($DBConnection, $SQLstring);
?>
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
				} elseif ($_SESSION['auth'] < 3)
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
									<li class=\"active\">
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
					<!-- INCIDENT FORM -->
					<div class="row">
						<div class="col-lg-10">
						<?php
						if($_SESSION['success'])
						{
							echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
							$_SESSION['success'] = "";
						}
						?>
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Add User</h5>
								</div>
								<div class="ibox-content">
									<form method="POST" class="form-horizontal" action="class/formProcessing.php">
										<input type="hidden" name="method" value="addUser">
										<div class="form-group"><label class="col-sm-2 control-label">User Name</label>
											<div class="col-sm-10"><input type="text" name="name" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Surname</label>
											<div class="col-sm-10"><input type="text" name="surname" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Email</label>
											<div class="col-sm-10"><input type="email" name="email" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Password</label>
											<div class="col-sm-10"><input type="password" name="password" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Company Name</label>
											<div class="col-sm-10">
												<select class="form-control" name="company">
													<?php
														while($row = mysqli_fetch_assoc($query)){
													?>
													<option value="<?php echo $row['ClientID']; ?>"><?php echo $row['ClientName']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Role</label>
											<div class="col-sm-10"><input type="text" name="role" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Phone Number</label>
											<div class="col-sm-10"><input type="text" name="phonenumber" class="form-control" required></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group">
											<div class="col-sm-4 col-sm-offset-2">
												<button class="btn btn-white" type="reset">Reset</button>
												<button class="btn btn-primary" type="submit">Add User</button>
											</div>
										</div>
									</form>
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