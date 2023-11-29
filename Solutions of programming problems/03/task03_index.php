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

	function countNumbers ($numbers) {
		$counts = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

		foreach ($numbers as $number) {
			$counts[$number]++;
		}

		return $counts;
	}

	function correctNumber($guess) {
		return $_SESSION['number'][0] == $guess[0]->number && $_SESSION['number'][1] == $guess[1]->number && $_SESSION['number'][2] == $guess[2]->number && $_SESSION['number'][3] == $guess[3]->number && $_SESSION['number'][4] == $guess[4]->number;
	}

	if (!isset($_SESSION['number']) || isset($_GET['submit_new'])) {
		$_SESSION['number'] = [rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9), rand(0, 9)];
		$_SESSION['countOfNumber'] = countNumbers($_SESSION['number']);
		$_SESSION['done'] = false;
		$_SESSION['tries'] = array(array());
	}

	if (isset($_POST['submit_guess'])) {
		$newGuess = array(
			new Guess('dark', $_POST['number_1']),
			new Guess('dark', $_POST['number_2']),
			new Guess('dark', $_POST['number_3']),
			new Guess('dark', $_POST['number_4']),
			new Guess('dark', $_POST['number_5'])
		);
		
		if (correctNumber($newGuess)) {
			$_SESSION['done'] = true;
			$newGuess[0]->type = 'success';
			$newGuess[1]->type = 'success';
			$newGuess[2]->type = 'success';
			$newGuess[3]->type = 'success';
			$newGuess[4]->type = 'success';
			
		} else {
			$currentCounts = $_SESSION['countOfNumber'];
			
			// CHECK FULL CORRECT
			for ($i = 0; $i < count($newGuess); $i++) {
				if ($_SESSION['number'][$i] == $newGuess[$i]->number) {
					$currentCounts[$newGuess[$i]->number]--;
					$newGuess[$i]->type = 'success';
				}
			}
			
			// CHECK PART CORRECT
			for ($i = 0; $i < count($newGuess); $i++) {
				if ($newGuess[$i]->type != 'success' && $currentCounts[$newGuess[$i]->number] > 0) {
					$currentCounts[$newGuess[$i]->number]--;
					$newGuess[$i]->type = 'info';
				}
			}
		}

		array_push($_SESSION['tries'], $newGuess);
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
			<div class="card bg-light shadow px-5 pt-4 pb-3">
				<table class="w-100">
					<tr>
						<td class="text-center" colspan="12"><h1>Guess the number</h1></td>
					</tr>
					<tr class="row mb-4">
						<td class="col-4 text-center" colspan="2">
							<div class="alert alert-dark mx-auto" style="max-width: 192px" role="alert">
								Incorrect number
							</div>
						</td>
						<td class="col-4 text-center" colspan="2">
							<div class="alert alert-info mx-auto" style="max-width: 192px" role="alert">
								Correct number
							</div>
						</td>
						<td class="col-4 text-center" colspan="2">
							<div class="alert alert-success" style="margin-left: 9px; max-width: 192px" role="alert">
								<a style="font-size: 0.8rem">Correct number and place</a>
							</div>
						</td>
					</tr>
					<?php foreach($_SESSION['tries'] as $try) { ?>
						<tr class="row">
							<?php foreach($try as $guess) { ?>
								<td class="col-2 text-center">
									<div class="alert alert-<?php echo $guess->type; ?>  mx-auto" style="max-width: 75px"role="alert">
										<?php echo $guess->number; ?>
									</div>
								</td>
							<?php } ?>
							<td class="col-2"></td>
						</tr>
					<?php } ?>
					<tr class="row">
						<?php if(!$_SESSION['done']) { ?>
							<form name="form1" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
								<td class="col-2"><input style="max-width: 75px" type="number" min="0" max="9" maxlength="1" class="form-control mx-auto" name="number_1" required></td>
								<td class="col-2"><input style="max-width: 75px" type="number" min="0" max="9" maxlength="1" class="form-control mx-auto" name="number_2" required></td>
								<td class="col-2"><input style="max-width: 75px" type="number" min="0" max="9" maxlength="1" class="form-control mx-auto" name="number_3" required></td>
								<td class="col-2"><input style="max-width: 75px" type="number" min="0" max="9" maxlength="1" class="form-control mx-auto" name="number_4" required></td>
								<td class="col-2"><input style="max-width: 75px" type="number" min="0" max="9" maxlength="1" class="form-control mx-auto" name="number_5" required></td>
								<td class="col-2 text-center"><button type="submit" name="submit_guess" class="btn btn-dark" value="submit_guess">Guess</button></td>
							</form>
						<?php } else { ?>
							<form name="form1" method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
								<td class="col-8">Congratulation! You guessed the number!</td>
								<td class="col-4"><button style="margin-left: 9px; max-width: 192px" type="submit" name="submit_new" class="btn btn-dark" value="submit_new">Generate new number</button></td>
							</form>
						<?php } ?>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
