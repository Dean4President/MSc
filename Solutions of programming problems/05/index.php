<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php
	session_start();

	if (!isset($_SESSION['enter'])){
		$_SESSION['enter'] = false; // we set it default value
		$_SESSION['userId'] = '';
		$_SESSION['username'] = '';
		$_SESSION['msg'] = 'Please log in!';
		$_SESSION['msgType'] = 'info';
		unset($_SESSION['number']);
	}

	if ($_SESSION['enter']) {
		header("Location: ./news.php");
	}

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$link=mysqli_connect('localhost','root','', 'php');
		
		// make a query, check the user and pass
		$sql='SELECT user_id, username, password, is_admin FROM users WHERE username="'.$username.'" and password="'.$password.'"';
		
		// get results from the database, using our query
		$result=mysqli_query($link, $sql);
		$result_array = $result->fetch_array();
		
		// if our query has only one row in result, we can login, if it is 0, we cannot
		if (mysqli_num_rows($result)==1){
			$_SESSION['enter'] = true;
			$_SESSION['userId'] = $result_array['user_id'];
			$_SESSION['username'] = $username;
			$_SESSION['isAdmin'] = $result_array['is_admin'] == 1;
			$_SESSION['msg'] = 'You are logged in successfully, '.$username.'!';
			$_SESSION['msgType'] = "success";
		}
		else {
			$_SESSION['enter'] = false;
			$_SESSION['userId'] = '';
			$_SESSION['username'] = '';
			$_SESSION['msg'] = "Incorrect username or password.";
			$_SESSION['msgType'] = "danger";
		}

		mysqli_close($link);
		
		header("Location: ./news.php");
	}

	$msg = $_SESSION['msg'];
	$msgType = $_SESSION['msgType'];
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