<?php
session_start();
session_destroy();
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

	<body class="gray-bg">

		<div class="middle-box text-center loginscreen  animated fadeInDown">
			<div>
				<div>
					<h1 class="logo-name">WS</h1>
				</div>
				<h3>Welcome to White Stone Support Desk</h3>
				<p>
					Created to support White Stones subscribed Clients. We are here for you.
				</p>
				<p>Login in. To start working with our specialists.</p>
				<form class="m-t" role="form" action="class/formProcessing.php" method="POST">
					<input type="hidden" name="method" value="login">
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email" required="">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password" required="">
					</div>
					<button type="submit" class="btn btn-primary block full-width m-b">Login</button>
					<a href="mailto:support@whitestone.com">
						<small>Forgot password?</small>
					</a>
				</form>
				<p class="m-t">
					<small>White Stone software company &copy; 2016</small>
				</p>
			</div>
		</div>

		<!-- SCRIPTS -->
			<?php include "scripts.php"; ?>

	</body>

</html>