<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php
	$db = [
		"kiskacsa" => "12345",
		"helo" => "helo",
	];
	$msg = "Please log in!";
	$msgType = "info";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		if ($db[$username] && $db[$username] === $password) {
			$msg = "You are logged in successfully.";
			$msgType = "success";
		}
		else {
			$msg = "Incorrect username or password.";
			$msgType = "danger";
		}
	}
?>

<html>
	<head>
		<style>
			.center {
				margin: 0;
				position: absolute;
				top: 50%;
				left: 50%;
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
			}
		</style>
	</head>
	<body>
		<div class="container center" style="max-width: 800px;">
			<?php if ($msg) { ?>
				<div class="alert alert-<?php echo $msgType?> shadow">
					<strong><?php echo $msg ?></strong>
				</div>
			<?php } ?>
			<div class="card bg-light shadow px-5 pt-4 pb-3">
				<form class="form" name="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div class="mb-3">
						<label class="form-label" for="username">Username</label>
						<input class="form-control" type="text" name="username" required/>
					</div>
					<div class="mb-3">
						<label class="form-label" for="password">Password</label>
						<input class="form-control" type="password" name="password" required/>
					</div>
					<div class="d-grid mt-4">
							<button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Log in</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
