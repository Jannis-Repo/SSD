<div class="row border-bottom">
	<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">

		<!-- NAV BAR MINIMIZER -->
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
		</div>
				
		<ul class="nav navbar-top-links navbar-right">
			<!-- WELCOME MESSAGE -->
			<li>
				<span class="m-r-sm text-muted welcome-message">Welcome to White Stone Support Desk.</span>
				<?php
					$sapi_type = php_sapi_name();
					if($sapi_type == "cgi-fcgi") {
				?>
				<span class="label label-primary"><i class="fa fa-lock" aria-hidden="true"></i>Mode Security: ON</span>
				<?php } else { ?>
					<span class="label label-danger">Mode Security: OFF</span>
				<?php } ?>
			</li>

			<?php 
				if($_SESSION['auth'] != 0 && $_SESSION['auth'] != 3)
				{

					$numberOfNewIncidents = 0;

					//Select incident records to display
					$TableNameIncident = "INCIDENT";
					$TableNameStatus = "INCIDENT_STATUS";
					$TableNameIncidentType = "INCIDENT_TYPE";
					$SQLstring = "SELECT $TableNameStatus.`IncidentID`, MAX(`StatusTypeID`), `IncidentTypeName` FROM $TableNameStatus, $TableNameIncident, $TableNameIncidentType WHERE $TableNameIncident.`IncidentID` = $TableNameStatus.`IncidentID` AND $TableNameIncident.`IncidentTypeID` = $TableNameIncidentType.`IncidentTypeID` GROUP BY `IncidentID` ORDER BY `DateStart` DESC";
					$QueryResult = mysqli_query($DBConnection, $SQLstring);

					while ($TableRow = mysqli_fetch_assoc($QueryResult))
					{
						if ($TableRow['MAX(`StatusTypeID`)'] == 1)
						{
							$numberOfNewIncidents += 1;
						}
					}

					echo "<!-- DROPDOWN LATEST INSTANCES -->
						<li class=\"dropdown\">
							<a class=\"dropdown-toggle count-info\" data-toggle=\"dropdown\" href=\"#\">
								<i class=\"fa fa-bell\"></i>";
								if($numberOfNewIncidents != 0)
								{
									echo "<span class=\"label label-primary\">" . $numberOfNewIncidents . "</span>";
								}
							echo "</a>

							<ul class=\"dropdown-menu dropdown-alerts\">";

					$QueryResult = mysqli_query($DBConnection, $SQLstring);
					if($numberOfNewIncidents > 3){
						$rowBlocker = 0;
						while($row = mysqli_fetch_assoc($QueryResult))
						{
							if ($row['MAX(`StatusTypeID`)'] == 1)
							{
								echo "<li>
										<a href=\"editIncident.php?IncidentID=" . $row['IncidentID'] . "\">
											<div>
												<i class=\"fa fa-edit\"></i>
												Incident no " . $row['IncidentID'] . "
												<small>" . $row['IncidentTypeName'] . "</small>
											</div>
										</a>
									</li>
									<li class=\"divider\"></li>";
								$rowBlocker += 1;
							}
							if($rowBlocker == 3)
							{
								break;
							}
						}
					}
					elseif($numberOfNewIncidents > 0)
					{
						while($row = mysqli_fetch_assoc($QueryResult))
						{
							if ($row['MAX(`StatusTypeID`)'] == 1)
							{
								echo "<li>
										<a href=\"editIncident.php?IncidentID=" . $row['IncidentID'] . "\">
											<div>
												<i class=\"fa fa-edit\"></i>
												Incident no " . $row['IncidentID'] . " 
												<small>" . $row['IncidentTypeName'] . "</small>
											</div>
										</a>
									</li>
									<li class=\"divider\"></li>";
							}
						}
					}

					if($numberOfNewIncidents == 0){
						echo "<li>
								<div class=\"text-center link-block\">
									<strong>There are no new incidents</strong>
								</div>
							</li>
							</ul>
						</li>";
					}
					else
					{
						echo "<li>
								<div class=\"text-center link-block\">
									<a href=\"newIncidents.php\">
										<strong>See All New Incidents</strong>
										<i class=\"fa fa-angle-right\"></i>
									</a>
								</div>
							</li>
							</ul>
						</li>";
					}

					mysqli_free_result($QueryResult);
				}

			?>

			<!-- LOGOUT LINK -->
			<li>
				<a href="login.php">
					<i class="fa fa-sign-out"></i> Log out
				</a>
			</li>
		</ul>

	</nav>
</div>
