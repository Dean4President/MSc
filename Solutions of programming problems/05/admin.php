<?php
	session_start();
	
	if(!$_SESSION['enter']) {
		header("Location: ./index.php");
	}
	
	$link=mysqli_connect('localhost','root','', 'php');

	if(!$_SESSION['isAdmin']){
		header("Location: ./news.php");
	}


	if(isset($_POST['editButton'])) {
		$user_id = $_POST['editButton'];

		$sql='SELECT * FROM users WHERE user_id = '.$user_id;
		$result = mysqli_fetch_array(mysqli_query($link, $sql));

		$username = $result['username'];
		$password = $result['password'];
		$isAdmin = $result['is_admin'];
	}
	if(isset($_POST['deleteButton'])) {
		$user_id = $_POST['deleteButton'];

		$sql='DELETE FROM users WHERE user_id = '.$user_id;
		$result=mysqli_query($link, $sql);

		$_SESSION['msg'] = 'ID-'.$user_id.' succesfully deleted';
		$_SESSION['msgType'] = "success";

		header("Refresh:0");
	}
	if(isset($_POST['submitNewUser'])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$isAdmin = $_POST["isAdmin"];

		$sql='INSERT INTO users (username, password, is_admin) VALUES ("'.$username.'", "'.$password.'", '.$isAdmin.')';
		mysqli_query($link, $sql);

		$_SESSION['msg'] = $username.' succesfully created';
		$_SESSION['msgType'] = "success";

		header("Refresh:0");
	}
	if(isset($_POST['submitEditUser'])) {
		$user_id = $_POST['submitEditUser'];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$isAdmin = $_POST["isAdmin"];

		if(isset($_POST["isAdmin"])){
			echo $_POST["isAdmin"];
		}
		echo json_encode($_POST);

		$sql='UPDATE users SET username = "'.$username.'", password = "'.$password.'", is_admin = '.$isAdmin.' WHERE user_id = '.$user_id;
		mysqli_query($link, $sql);

		$_SESSION['msg'] = $username.' succesfully edited';
		$_SESSION['msgType'] = "success";

		// header("Refresh:0");
	}

	
	// make a query, check the user and pass
	$sql='SELECT user_id, username, is_admin FROM users';

	// get results from the database, using our query
	$results=mysqli_query($link, $sql);

	mysqli_close($link);

	$msg = $_SESSION['msg'];
	$msgType = $_SESSION['msgType'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
		<?php include("./nav.php"); ?>
		<div class="container center" style="max-width: 800px;">
			<?php if ($msg) { ?>
				<div class="alert alert-<?php echo $msgType?> shadow">
					<strong><?php echo $msg ?></strong>
				</div>
			<?php } ?>
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
							<div class="mb-3">
								<label class="form-label">Admin</label>
								<input class="form-check-input" type="radio" name="isAdmin" id="isAdminFalse" value="1">
								<label class="form-check-label" for="isAdminTrue">
									True
								</label>
								<input class="form-check-input" type="radio" name="isAdmin" id="isAdminFalse" value="0" checked>
								<label class="form-check-label" for="isAdminFalse">
									False
								</label>
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
							<div class="mb-3">
								<label class="form-label">Admin</label>
								<input class="form-check-input" type="radio" name="isAdmin" id="isAdminTrue" value="1" <?php if ($isAdmin) { echo 'checked'; } ?>>
								<label class="form-check-label" for="isAdminTrue">
									True
								</label>
								<input class="form-check-input" type="radio" name="isAdmin" id="isAdminFalse" value="0" <?php if (!$isAdmin) { echo 'checked'; } ?>>
								<label class="form-check-label" for="isAdminFalse">
									False
								</label>
							</div>
							<div class="d-grid mt-4">
								<button class="btn btn-primary btn-lg btn-block" type="submit" name="submitEditUser" value='<?php echo $user_id ?>'>Save user</button>
							</div>
					</form>
				</div>
			<?php } ?>

			<div class="card shadow">
				<div class="card-header">
					<table class="table">
						<tr class="row mb-4">
							<td class="col-9 text-center" colspan="3"><h1>Admin page</h1></td>
							<td class="col-3 text-center">
								<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
									<button class="btn btn-primary" type="submit" name="newButton" >Add new user</button>
								</form>
							</td>
						</tr>
						<tr class="row">
							<th scope="col" class="col-3">ID</td>
							<th scope="col" class="col-4">USERNAME</td>
							<th scope="col" class="col-2">IS ADMIN</td>
							<th scope="col" class="col-3">ACTIONS</td>
						</tr>
						<?php foreach($results as $result) { ?>
							<tr class="row">
								<td class="col-3"><?php echo $result['user_id'] ?></td>
								<td class="col-4"><?php echo $result['username'] ?></td>
								<td class="col-2"><?php echo $result['is_admin'] == 1 ? "true" : "false" ?></td>
								<td class="col-3">
									<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
										<button class="btn btn-info" type="submit" name="editButton" value="<?php echo $result['user_id'] ?>">Edit</button>
										<button class="btn btn-danger" type="submit" name="deleteButton" value="<?php echo $result['user_id'] ?>">Delete</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>