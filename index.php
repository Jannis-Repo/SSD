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
									<h5>Incidents in progress</h5>
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
													<th>Priority</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												<?php

													//Select incident records to display
													$TableNameIncident = "INCIDENT";
													$TableNameStatus = "INCIDENT_STATUS";
													$TableNameStatusType = "STATUS";
													$TableNameIncidentType = "INCIDENT_TYPE";
													$SQLstring = "SELECT $TableNameIncident.`IncidentID`, `Description`, `Solution`, `IncidentTypeName`, `Priority`, `StatusName`, `DateStart`, MAX(`Date`) FROM $TableNameIncident, $TableNameStatus, $TableNameStatusType, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` IS $TableNameStatus.`IncidentID`, $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID`, $TableNameStatus.`StatusTypeID` = $TableNameStatusType.`StatusTypeID` GROUP BY $TableNameStatus.`IncidentID`";
													$QueryResultIncident = mysqli_query($DBConnection, $SQLstring);

													//Display results in a table format
													while ($IncidentRow = mysqli_fetch_assoc($QueryResultIncident))
													{
														echo "<tr>";
														echo "<td>{$IncidentRow['IncidentID']}</td>";
														echo "<td>{$IncidentRow['Description']}</td>";
														echo "<td>{$IncidentRow['Solution']}</td>";
														echo "<td>{$IncidentRow['IncidentTypeName']}</td>";
														echo "<td>{$IncidentRow['StatusName']}</td>";
														echo "<td>{$IncidentRow['Priority']}</td>";
														echo "<td>{$IncidentRow['DateStart']}</td>";
														echo "<td><a href=\"editIncident.php\"><i class=\"fa fa-edit\"></i></a></td>";
														echo "</tr>";
													}
													mysqli_free_result($QueryResult);

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