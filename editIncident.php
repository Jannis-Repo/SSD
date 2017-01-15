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
			<?php include "sideNav.php"; ?>

			<div id="page-wrapper" class="gray-bg">
				
				<!-- TOP MENU -->
				<?php include "topNav.php"; ?>

				<div class="row wrapper border-bottom white-bg page-heading">
					<!-- INCIDENT HEADER -->
					<div class="col-lg-10">
						<h2>Incident No. 1</h2>
						<ol class="breadcrumb">
							<li>
								This is the description of the incident.
							</li>
						</ol>
					</div>
				</div>

				<div class="wrapper wrapper-content">
					<div class="row">
						<!-- ADD STATUS -->
						<div class="col-sm-6">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Change status</h5>
									<div class="ibox-tools">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<p>Change the status of this incident.</p>
									<form role="form" action="class/formProcessing.php" method="POST">
										<div class="form-group">
											<label>Choose status</label>
											<select class="form-control" name="account">
												<option value="2">Pending</option>
												<option value="3">Forwarded to Engineer</option>
												<option value="4">Forwarded to Account Manager</option>
												<option value="5">Resolved</option>
												<option value="6">Closed</option>
											</select>
										</div>
										<div class="form-group">
											<label>Solution</label>
											<input type="text" class="form-control">
										</div>
										<input type="hidden" name="method" value="changeStatus">
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
									<div class="ibox-tools">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
								</div>
								<div class="ibox-content">
									<p>Set a new priority for this incident.</p>
									<form role="form" action="class/formProcessing.php" method="POST">
										<div class="form-group">
											<select class="form-control" name="account">
												<option value="High">High</option>
												<option value="Medium">Medium</option>
												<option value="Low">Low</option>
											</select>
										</div>
										<input type="hidden" name="method" value="changePriority">
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
									<div class="ibox-tools">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</div>
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
														echo "<option value=\"{$Row['EmployeeID']}\">{$Row['EmployeeID']} {$Row['EmployeeName']} {$Row['EmployeeSurname']}</option>";
													}
													mysqli_free_result($QueryResult);

												?>

											</select>
										</div>
										<input type="hidden" name="method" value="assignIncident">
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