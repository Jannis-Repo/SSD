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
					<!-- INCIDENTS TABLE -->
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox float-e-margins">
								<!-- TABLE DESCRIPTION AND FUNCTION -->
								<div class="ibox-title">
									<h5>New Incidents</h5>
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
													<th>Type</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>This is example of an incident</td>
													<td></td>
													<td>4 Jan, 2017</td>
													<td>
														<a href="editIncident.php"><i class="fa fa-edit"></i></a>
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>This is example of an incident</td>
													<td></td>
													<td>4 Jan, 2017</td>
													<td>
														<a href="editIncident.php"><i class="fa fa-edit"></i></a>
													</td>
												</tr>
												<tr>
													<td>3</td>
													<td>This is example of an incident</td>
													<td></td>
													<td>4 Jan, 2017</td>
													<td>
														<a href="editIncident.php"><i class="fa fa-edit"></i></a>
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>This is example of an incident</td>
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
				</div>

				<!-- FOOTER WITH COPYRIGHT -->
				<?php include "footer.php"; ?>

			</div>
		</div>

		<!-- SCRIPTS -->
		<?php include "scripts.php"; ?>
		
	</body>

</html>