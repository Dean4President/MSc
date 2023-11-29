<?php	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$link=mysqli_connect('localhost','root','', 'php');
		
		// make a query, check the user and pass
		$sql='SELECT user_id, username, password FROM users WHERE username="'.$username.'" and password="'.$password.'"';
		
		// get results from the database, using our query
		$result=mysqli_query($link, $sql);
		
		// if our query has only one row in result, we can login, if it is 0, we cannot
		if (mysqli_num_rows($result)==1){
			$_SESSION['enter'] = true;
			$_SESSION['game'] = true;
			$_SESSION['stat'] = false;
			$_SESSION['userId'] = $result->fetch_array()['user_id'];
			$_SESSION['username'] = $username;
			$_SESSION['msg'] = 'You are logged in successfully, '.$username.'!';
			$_SESSION['msgType'] = "success";
		}
		else {
			$_SESSION['enter'] = false;
			$_SESSION['game'] = false;
			$_SESSION['stat'] = false;
			$_SESSION['userId'] = '';
			$_SESSION['username'] = '';
			$_SESSION['msg'] = "Incorrect username or password.";
			$_SESSION['msgType'] = "danger";
		}

		mysqli_close($link);
		
		header("Refresh:0");
	}
?>
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