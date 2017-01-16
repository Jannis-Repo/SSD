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
					<!-- INCIDENT FORM -->
					<div class="row">
						<div class="col-lg-10">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Add User</h5>
								</div>
								<div class="ibox-content">
									<form method="POST" class="form-horizontal" action="">
										<div class="form-group"><label class="col-sm-2 control-label">User Name</label>
											<div class="col-sm-10"><input type="text" class="form-control"></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Surname</label>
											<div class="col-sm-10"><input type="text" class="form-control"></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Email</label>
											<div class="col-sm-10"><input type="email" class="form-control"></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">User Password</label>
											<div class="col-sm-10"><input type="password" class="form-control"></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Company Name</label>
											<div class="col-sm-10">
												<select class="form-control" name="account">
													<option>Company 1</option>
													<option>Company 2</option>
													<option>Company 3</option>
													<option>Company 4</option>
													<option>Company 5</option>
													<option>Company 6</option>
												</select>
											</div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Role</label>
											<div class="col-sm-10"><input type="text" class="form-control"></div>
										</div>
										<div class="hr-line-dashed"></div>
										<div class="form-group"><label class="col-sm-2 control-label">Phone Number</label>
											<div class="col-sm-10"><input type="text" class="form-control"></div>
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