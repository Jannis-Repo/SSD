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

				<div class="wrapper wrapper-content">
					<!-- PROFILE DETAILS -->
					<div class="col-md-4">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Profile Details</h5>
							</div>
							<div>
								<div class="ibox-content no-padding border-left-right">
									<img alt="image" class="img-responsive" src="<?php echo $sideNavRow['PICTURE']; ?>">
								</div>
								<div class="ibox-content profile-content">
									<h4>
										<strong><?php echo utf8_decode($sideNavRow['EmployeeName']) . ' ' . utf8_decode($sideNavRow['EmployeeSurname']); ?></strong><br>
										<small><?php echo $authorisationName[$_SESSION['auth']]; ?></small>
									</h4>
									<p>
										<i class="fa fa-desktop"></i>  <?php echo $sideNavRow['EmployeeEmail']; ?>
									</p>
									<div class="row m-t-lg">
										<div class="col-md-6">
											<span class="label label-primary">169</span>
											<h5>Solved Incidents</h5>
										</div>
										<div class="col-md-6">
											<span class="label label-primary">1</span>
											<h5>In progress</h5>
										</div>
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
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>
							<!-- TABLE DATA -->
							<div class="ibox-content">
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
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
										<tbody>
											<tr>
												<td>1</td>
												<td>This is example of an incident</td>
												<td></td>
												<td></td>
												<td></td>
												<td>4 Jan, 2017</td>
												<td>
													<a href="editIncident.php"><i class="fa fa-edit"></i></a>
												</td>
											</tr>
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