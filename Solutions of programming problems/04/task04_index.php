<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php
	session_start();
	
	class Guess {
		public $type; 
		public $number;

		function __construct(string $type, string $number) {
			$this->type = $type;
			$this->number = $number;
		}
	}

	if (!isset($_SESSION['enter']) || isset($_GET['exit'])){
		$_SESSION['enter'] = false; // we set it default value
		$_SESSION['game'] = false;
		$_SESSION['stat'] = false;
		$_SESSION['userId'] = '';
		$_SESSION['username'] = '';
		$_SESSION['msg'] = 'Please log in!';
		$_SESSION['msgType'] = 'info';
		unset($_SESSION['number']);
	}


	if (isset($_GET['goto_admin'])) {
		$_SESSION['game'] = false;
		$_SESSION['stat'] = false;
	}
	if(isset($_GET['goto_game'])) {
		$_SESSION['game'] = true;
		$_SESSION['stat'] = false;
	}
	if(isset($_GET['goto_stat'])) {
		$_SESSION['game'] = true;
		$_SESSION['stat'] = true;
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
			
			<?php
				if(!$_SESSION['enter']) {
					include 'task04_login.php';
				}
				else {
					if(!$_SESSION['game']) {
						include 'task04_admin.php';
					}
					else {
						if(!$_SESSION['stat']){
							include 'task04_game.php';
						}
						else {
							include 'task04_stat.php';
						}
					}
				}
			?>
		</div>
	</body>
</html>