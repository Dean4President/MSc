<?php
	session_start();
	
	if(!$_SESSION['enter']) {
		header("Location: ./index.php");
	}

	$link=mysqli_connect('localhost','root','', 'php');

	// make a query, check the user and pass
	$sql='SELECT news_id, title, username, newsbody
		FROM news
		INNER JOIN users USING(user_id)';

	// get results from the database, using our query
	$results=mysqli_query($link, $sql);

	
	if(isset($_POST['deleteButton'])) {
		$news_id = $_POST['deleteButton'];

		$sql='DELETE FROM news WHERE news_id = '.$news_id;
		$result=mysqli_query($link, $sql);

		header("Refresh:0");
	}

	mysqli_close($link);
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
			<a class="btn btn-info mb-3" href="editnews.php?new=1">Create new post</a>
			<?php foreach($results as $result) { ?>
				<div class="card shadow mb-5">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0"><?php echo $result['title']; ?></h5>
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
							<?php if ($_SESSION['isAdmin'] || $_SESSION['username'] == $result['username']) { ?>
								<a class="btn btn-info" href="editnews.php?news_id=<?php echo $result['news_id']; ?>&new=0">Edit</a>
								<button class="btn btn-danger" type="submit" name="deleteButton" value="<?php echo $result['news_id']; ?>">Delete</button>
							<?php } ?>
						</form>
					</div>
					<div class="card-body">
						<p class="card-text"><?php echo $result['newsbody']; ?></p>
					</div>
					<div class="card-footer">
						<h6 class="card-subtitle text-muted">Author: <?php echo $result['username']; ?></h6>
					</div>
				</div>
			<?php } ?>
		</div>
	</body>
</html>