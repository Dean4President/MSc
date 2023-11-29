<?php
	$link=mysqli_connect('localhost','root','', 'php');

	if(isset($_POST['editButton'])) {
		$id = $_POST['editButton'];

		$sql='SELECT * FROM users WHERE id = '.$id;
		$result = mysqli_fetch_array(mysqli_query($link, $sql));

		$username = $result['username'];
		$password = $result['password'];
	}
	if(isset($_POST['deleteButton'])) {
		$id = $_POST['deleteButton'];

		$sql='DELETE FROM users WHERE id = '.$id;
		$result=mysqli_query($link, $sql);

		$_SESSION['msg'] = 'ID-'.$id.' succesfully deleted';
		$_SESSION['msgType'] = "success";

		header("Refresh:0");
	}
	if(isset($_POST['submitNewUser'])) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql='INSERT INTO users (username, password) VALUES ("'.$username.'", "'.$password.'")';
		mysqli_query($link, $sql);

		$_SESSION['msg'] = $username.' succesfully created';
		$_SESSION['msgType'] = "success";

		header("Refresh:0");
	}
	if(isset($_POST['submitEditUser'])) {
		$id = $_POST['submitEditUser'];
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql='UPDATE users SET username = "'.$username.'", password = "'.$password.'" WHERE id = '.$id;
		mysqli_query($link, $sql);

		$_SESSION['msg'] = $username.' succesfully edited';
		$_SESSION['msgType'] = "success";

		header("Refresh:0");
	}

	
	// make a query, check the user and pass
	$sql='SELECT user_id, username FROM users';

	// get results from the database, using our query
	$results=mysqli_query($link, $sql);

	mysqli_close($link);
?>

<?php if(isset($_POST['newButton'])) { ?>
	<div class="card bg-light shadow mb-3 px-5 pt-4 pb-3"">
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
					<button class="btn btn-primary btn-lg btn-block" type="submit" name="submitNewUser">Add user</button>
				</div>
		</form>
	</div>
<?php } ?>

<?php if(isset($_POST['editButton'])) { ?>
	<div class="card bg-light shadow px-5 pt-4 pb-3"">
		<form class="form" name="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="mb-3">
					<label class="form-label" for="username">Username</label>
					<input class="form-control" type="text" name="username" value='<?php echo $username ?>' required/>
				</div>
				<div class="mb-3">
					<label class="form-label" for="password">Password</label>
					<input class="form-control" type="password" name="password" value='<?php echo $password ?>' required/>
				</div>
				<div class="d-grid mt-4">
					<button class="btn btn-primary btn-lg btn-block" type="submit" name="submitEditUser" value='<?php echo $id ?>'>Save user</button>
				</div>
		</form>
	</div>
<?php } ?>

<div class="card shadow">
	<div class="card-header">
		<div class="d-flex justify-content-between">
			<div>Admin page</div>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>"><button class="btn btn-primary" type="submit" name="newButton" >Add new user</button></form>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"><button class="btn btn-success" type="submit" name="goto_game" >Play!</button></form>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"><button class="btn btn-info" type="submit" name="goto_stat" >Stats</button></form>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>"><button class="btn btn-dark" type="submit" name="exit" >Log out</button></form>
		</div>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="d-flex justify-content-around">
				<div class="d-table">
					<p class="d-table-cell align-middle">ID</p>
				</div>
				<div class="d-table">
					<p class="d-table-cell align-middle">USERNAME</p>
				</div>
				<div>
					<p class="d-table-cell align-middle">ACTIONS</p>
				</div>
			</div>
		</li>
		<?php foreach($results as $result) { ?>
			<li class="list-group-item">
				<div class="d-flex justify-content-around">
					<div class="d-table">
						<p class="d-table-cell align-middle"><?php echo $result['user_id'] ?></p>
					</div>
					<div class="d-table">
						<p class="d-table-cell align-middle"><?php echo $result['username'] ?></p>
					</div>
					<div>
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
							<button class="btn btn-info" type="submit" name="editButton" value="<?php echo $result['id'] ?>">Edit</button>
							<button class="btn btn-danger" type="submit" name="deleteButton" value="<?php echo $result['id'] ?>">Delete</button>
						</form>
					</div>
				</div>
			</li>
		<?php } ?>
	</ul>
</div>