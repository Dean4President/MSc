<?php
	session_start();
	
	if(!$_SESSION['enter']) {
		header("Location: ./index.php");
	}

	$isEditing = false;

	if(!isset($_GET['new']) && !isset($_POST['saveNews'])) {
		header("Location: ./news.php");
	}

	if(isset($_GET['new'])) {
		$isEditing = $_GET['new'] == 0;
	}

	$link=mysqli_connect('localhost','root','', 'php');

	$newsId = '';
	$title = '';
	$newsBody = '';

	if($isEditing && isset($_GET['news_id'])) {
		$sql='SELECT title, username, newsbody
		FROM news
		INNER JOIN users USING(user_id)
		WHERE news_id = '.$_GET['news_id'];

		$result=mysqli_query($link, $sql)->fetch_array();
		$title = $result['title'];
		$newsBody = $result['newsbody'];
		$newsId = $_GET['news_id'];
	}

	if(isset($_POST['saveNews'])) {
		if($_POST['isediting'] == 0) {
			echo json_encode($_SESSION['userId']);
			echo json_encode($_POST["title"]);
			echo json_encode($_POST["newsBody"]);

			$sql = 'INSERT INTO news (user_id, title, newsbody) VALUES ('.$_SESSION["userId"].', "'.$_POST["title"].'", "'.$_POST["newsBody"].'")';
			mysqli_query($link, $sql);

			header("Location: ./news.php");
		}
		else {
			$sql='UPDATE news SET title = "'.$_POST["title"].'", newsbody = "'.$_POST["newsBody"].'" WHERE news_id = '.$_POST['news_id'];
			mysqli_query($link, $sql);

			header("Location: ./news.php");
		}
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
			<div class="card bg-light shadow px-5 pt-4 pb-3"">
				<form class="form" name="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<input class="form-control" type="text" name="news_id" hidden value='<?php echo $newsId ?>'/>
						<input class="form-control" type="text" name="isediting" hidden value='<?php echo $isEditing ? 1 : 0 ?>'/>
						<div class="mb-3">
							<label class="form-label" for="title">Title</label>
							<input class="form-control" type="text" name="title" value='<?php echo $title ?>'required/>
						</div>
						<div class="mb-3">
							<label class="form-label" for="newsBody">Password</label>
  							<textarea class="form-control" id="newsBody" name="newsBody" rows="10"><?php echo $newsBody ?></textarea>
						</div>
						<div class="d-grid mt-4">
							<button class="btn btn-primary btn-lg btn-block" type="submit" name="saveNews" value='saveNews'>Save post</button>
						</div>
				</form>
			</div>
		</div>
	</body>
</html>